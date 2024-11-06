<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDesignRequest;
use App\Http\Requests\UpdateDesignRequest;
use App\Models\Design;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\Brand;
use App\Models\Admin\Color;
use App\Models\Admin\Template;
use App\Models\Admin\ProductTag;
use App\Models\Admin\Size;
use App\Models\Stock;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('front.pages.design.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDesignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesignRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDesignRequest  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDesignRequest $request, Design $design)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $item = Design::find($slug);
        if ($item) {

            // Get the full path to the item image
            $imagePath = public_path('uploaded_files\design\\' . $item->design_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $item->delete();
            Cart::destroy();
            return Redirect::to('/');
        } else {

            // Item not found error or further actions
            return Redirect::to('/');
        }
    }

    public function DesignDelete($slug)
    {
        $item = Design::find($slug);
        $product_id = $item->product_id;

        if ($item) {

            // Get the full path to the item image
            $imagePath = public_path('uploaded_files\design\\' . $item->design_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $item->delete();
            Cart::destroy();
            return redirect()->route('design.product', ['slug' => $product_id]);
        } else {

            // Item not found error or further actions
            return Redirect::to('/');
        }
    }


    public function DesignProduct($slug){
        
        Cart::destroy();
        $project = Product::where('en_Product_Slug', $slug)
            ->orWhere('id', $slug)
            ->with('category')->first();

        $cat_id = $project->category->id;
        $products = Product::where('id',$project->id)->with('brand','category','colors','sizes','stocks','product_tags', 'product_reviews', 'product_reviews.user')->latest()->first();
        $stocks = $products->stocks;

        $data['slug'] = $slug;
        $data['stocks'] = $stocks;
        $data['product'] = $products;
        $data['title'] = $products->en_Product_Name;
        $data['description'] = $products->en_Product_Nam;
        $data['keywords'] = $products->en_Product_Nam;

        return view('front.pages.design.index',$data);

        // return view('front.pages.design.index',['product'=> $product]);
    }


    public function BuyNow(Request $request){


        if (!empty($request->design_image)) {
            $imageName = fileUpload($request['design_image'], DesignImage());
        } else {
            $imageName = '';
        }

        if (!empty($request->logo)) {
            $logoName = fileUpload($request['logo'], DesignLogo());

        } else {
            $logoName = '';
        }


        $inputData = $request->all();
        $sizes = Size::get();
        $allsize=[];
        $quantity = 0;

        foreach ($inputData as $key => $value) {
            foreach($sizes as $size){
                if($key==$size->Size){
                    $allsize[$key]=$value;
                    $quantity += $value;
                }
            }
        }

        $request['quantity'] = $quantity;
        $request['sizebyqty'] = $allsize;

        $product=Product::with('colors','sizes')->where('id',$request->product_id)->first();
        $color_id = DB::table('color_product')->where('Product_Id', $request->product_id)->where('Color_Id', $request->selected_color_id)->count();
        $size_id = DB::table('size_product')->where('Product_Id', $request->product_id)->where('Size_Id', null)->count();

        if($color_id == 0 ){
            $color_id = null;
        }
        if($size_id == 0){
            $size_id=null;
        }
        $color_name=Color::where('ColorCode',$request->selected_color_id)->first();
        $size_name=Size::where('id',$request->size_id)->first();

        $design = new Design();
        $design->design_image = $imageName;
        $design->uploaded_image = $logoName;
        $design->product_color = $color_name->Name ?? '';
        $design->print_type = $request->print_type;
        $design->instruction = $request->instruction;
        $design->product_id = $product->id;
        $design->Status = 0;
        $design->user_id = $user->id ?? null;
        $design->save();
        $insertedId = $design->id;



        $cart= Cart::add([
            'id' => $request->product_id,
            'name' => $product->en_Product_Name,
            'qty' => $request->quantity,
            'price' => $product->Discount_Price+$request->print_price,
            'weight' => $product->Price+$request->print_price,

            'options' =>
                ['size' => $size_id == 0 ? $size_id : $size_name->Size,
                    'color' => $color_id == 0 ? $color_id : $color_name->ColorCode,
                    'image'=>$product->Primary_Image,
                    'discount_price'=> $product->Discount_Price,
                    'item_tag'=>$product->ItemTag,
                    'discount_parcent'=>$product->Discount,
                    'voucher'=>$product->Voucher,
                    'print_type' => $request->print_type,
                    'print_price' => $request->print_price,
                    'selected_color_id' => $request->selected_color_id,
                    'instruction' => $request->instruction,
                    'sizebyqty' => $request->sizebyqty,
                    'design_image' => $insertedId,
//                'logo' => $request->logo,
                ]
        ]);

        // Remove the 'design_image' key from options if it contains an UploadedFile instance
        if ($cart->options->has('design_image') && $cart->options->get('design_image') instanceof Illuminate\Http\UploadedFile) {
            $cart->options->forget('design_image');
        }

        Cart::update($cart->rowId, [
            'options' => $cart->options->toArray(),
        ]);


        return redirect()->route('checkout');
    }

    // Product Templates

    public function productTemplate(){

        $templates = Template::get();
        return view('admin.pages.product_template.list', compact('templates'));
    }

    public function CreateTemplate(){

        return view('admin.pages.product_template.add');
    }

    public function StoreTemplate(Request $request){

        $request->validate([
            'product_type' => 'required|unique:product_templates',
            'image' => 'required|image|mimes:png,jpg'
        ]);

        if (!empty($request->image)) {
            $TemplateImageName = fileUpload($request['image'], TemplateImage());
        }

        $template = new Template();
        $template->image = $TemplateImageName;
        $template->product_type = $request->product_type;
        $template->save();

        return redirect()->route('admin.template')->with('toast_success', __('Successfully Product Template Created!'));
    }

    public function EditTemplate($id){

        // Find the template by its ID
        $template = Template::find($id);

        if (!$template) {
            // Template not found, handle the error as needed (e.g., redirect back with an error message)
            return redirect()->back()->with('error', 'Template not found.');
        }

        if( $template->Status == 1){
            $template->Status = 0;
        }else  {
            $template->Status = 1;
        }
        // Update the status to "active"
        $template->save();

        // Redirect back with a success message or perform any other action as needed
        return redirect()->back()->with('success', 'Template status updated successfully.');
    }



}
