<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Admin\Blog;
use App\Models\Admin\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
class BlogController extends Controller
{
   public function blog(Request $request){

       if ($request->ajax()) {
           $data = Blog::with('tags')->get();
           return DataTables::of($data)
               ->addIndexColumn()
               ->addColumn('action', function ($data) {
                   $btn = '<div class="action__buttons">';
                   $btn = $btn.'<a href="' . route('admin.blog.edit', $data->id) . '" class="btn-action"><i class="fa-solid fa-pen-to-square"></i></a>';
                   $btn = $btn.'<a href="' . route('admin.blog.delete', $data->id) . '" class="btn-action delete"><i class="fas fa-trash-alt"></i></a>';
                   $btn = $btn.'</div>';
                   return $btn;
               })
               ->editColumn('Small_Image', function ($data) {
                   $url = asset(BlogImage() . $data->Small_Image);
                   return '<img src=' . $url . ' border="0" width="80"class="img-rounded" align="center" />';
               })
               ->editColumn('Big_Image', function ($data) {
                   $url = asset(BlogImage() . $data->Big_Image);
                   return '<img src=' . $url . ' border="0" width="120" class="img-rounded" align="center" />';
               })
               ->editColumn('Title', function ($data) {
                   return Str::limit($data->en_Title, 10);
               })
//               ->editColumn('Tags', function ($data) {
//                   $html = '';
//                   foreach ($data->tags as $tag){
//                       foreach ($tag->Tag as $n){
//                           $html= $html.'<span class="status active me-2">'.$n.'</span>';
//                       }
//                   }
//                   return $html;
//               })
               ->editColumn('Tags', function ($data) {
                   $html = '';
                   foreach ($data->tags as $tag){
                       if($tag->Tag == 'no-tag'){
                           $html = $tag->Tag;
                       }else {

                           foreach ($tag->Tag as $n){
                               $html= $html.'<span class="status active me-2">'.$n.'</span>';
                           }
                       }

                   }
                   return $html;
               })
               ->editColumn('Description_One', function ($data) {
                   return Str::limit($data->en_Description_One, 30);
               })
               ->editColumn('Description_Two', function ($data) {
                   return Str::limit($data->en_Description_Two, 80);
               })
               ->rawColumns(['action', 'Small_Image', 'Big_Image', 'Description_One', 'Description_Two','Title','Tags'])
               ->make(true);
       }
       $data['title'] = __('Blog List');
       return view('admin.pages.blog.index', $data);
   }
   public function blogCreate(){
       $data['title'] = __('Blogs');
       return view('admin.pages.blog.create', $data);
   }

   public function blogStore(BlogRequest $request){
       if (!empty($request->big_image)) {
           $big_image = fileUpload($request['big_image'], BlogImage());
       } else {
           return redirect()->back()->with('toast_error', __('Image is  required'));
       }
       if (!empty($request->small_image)) {
           $small_image = fileUpload($request['small_image'], BlogImage());
       } else {
           return redirect()->back()->with('toast_error', __('Image is  required'));
       }
       $blog = Blog::create([
           'en_Title' => $request->en_blog_title,
           'slug' => $request->en_blog_slug,
           'en_Description_One' => $request->en_description_one ?? '',
           'en_Description_Two' => $request->en_description_two ?? '',
           'Small_Image' => $small_image,
           'Big_Image' => $big_image,

           'fr_Title' => $request->fr_blog_title ?? 'No Title',
           'fr_Description_One' => $request->fr_description_one ?? 'No Description One',
           'fr_Description_Two' => $request->fr_description_two ?? 'No Description Two',
           'user_id' => Auth::id(),
       ]);
       if ($blog) {
           Tag::create([
               'blog_id'=>$blog->id,
               'Tag'=>$request->tag ?? 'no-tag'
           ]);

           // Blog Activity
           Activity::create([
               'log_name' => 'Blog Create',
               'description' => "Blog was {$blog->en_Title} Created",
               'subject_id' => $blog->id,
               'subject_type' => get_class($blog),
               'causer_id' => auth()->id(), // ID of the user who caused the activity
               'causer_type' => get_class(auth()->user()), // Class name of the user model
           ]);

           return redirect()->route('admin.blog')->with('toast_success', __('Successfully Stored !'));
       }
       return redirect()->back()->with('toast_error', __('Does not insert  !'));
   }
   public function blogDelete($id){

       $delete = Blog::Where('id', $id);
       if ($delete) {

           // Blog Activity
           $blog = Blog::find($id);
           Activity::create([
               'log_name' => 'Blog Delete',
               'description' => "Blog was {$blog->en_Title} Deleted",
               'subject_id' => $blog->id,
               'subject_type' => get_class($blog),
               'causer_id' => auth()->id(), // ID of the user who caused the activity
               'causer_type' => get_class(auth()->user()), // Class name of the user model
           ]);

           $delete->delete();
           return redirect()->route('admin.blog')->with('toast_success', __('Successfully Deleted !'));
       }
       return redirect()->route('admin.blog')->with('toast_error', __('Does Not Delete!'));
   }
   public function blogEdit($id){
           $edit = Blog::with('tags')->where('id', $id)->first();
           $title = __('Blogs');
           return view('admin.pages.blog.edit', compact('edit', 'title'));
   }
   public function blogUpdate(Request $request){
           $id = $request->id;
            $update = Blog::where('id',$id)->first();
           if (!empty($request->big_image)) {
               $big_image = fileUpload($request['big_image'], BlogImage());
           } else {
               $big_image = $update->Big_Image;
           }
           if (!empty($request->small_image)) {
               $small_image = fileUpload($request['small_image'], BlogImage());
           } else {
               $small_image = $update->Small_Image;
           }
             $blog = $update->update([
                 'en_Title' => is_null($request->en_blog_title) ? $update->en_Title : $request->en_blog_title,
                 'slug' => is_null($request->en_blog_slug) ? $update->en_blog_slug : $request->en_blog_slug,
                 'en_Description_One' => is_null($request->en_description_one) ? $update->en_Description_One : $request->en_description_one ?? '',
                 'en_Description_Two' => is_null($request->en_description_two) ? $update->en_Description_Two : $request->en_description_two ?? '',
                 'Small_Image' => $small_image,
                 'Big_Image' => $big_image,

                 'fr_Title' => is_null($request->fr_blog_title) ? $update->fr_Title : $request->fr_blog_title ?? 'No Title',
                 'fr_Description_One' => is_null($request->fr_description_one) ? $update->fr_Description_One : $request->fr_description_one ?? 'No Description',
                 'fr_Description_Two' => is_null($request->fr_description_two) ? $update->fr_Description_Two : $request->fr_description_two ?? 'No Description Two',
           ]);
       if ($blog) {
           if( is_null($request->tag)){
               Tag::where('blog_id',$id)->update([
                   'blog_id'=>$id,
                   'Tag'=> json_encode("no-tag")
               ]);
           }else{
               Tag::where('blog_id',$id)->update([
                   'blog_id'=>$id,
                   'Tag'=>is_null($request->tag) ? $update->Tag : $request->tag
               ]);
           }

           // Blog Activity
           $blog = Blog::find($id);
           Activity::create([
               'log_name' => 'Blog Update',
               'description' => "Blog was {$blog->en_Title} Updated",
               'subject_id' => $blog->id,
               'subject_type' => get_class($blog),
               'causer_id' => auth()->id(), // ID of the user who caused the activity
               'causer_type' => get_class(auth()->user()), // Class name of the user model
           ]);

           return redirect()->route('admin.blog')->with('toast_success', __('Successfully Stored !'));
       }
       return redirect()->back()->with('toast_error', __('Does not insert  !'));
       }
}
