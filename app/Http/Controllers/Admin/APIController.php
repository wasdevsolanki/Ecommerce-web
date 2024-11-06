<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\OrderConfirmMail;
use Illuminate\Http\Request;
use App\Models\Admin\API;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\Order;
use App\Models\Stock;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Crypt;



class APIController extends Controller
{
    public function index(){
        $apilist = API::latest()->get();

        return view('admin.pages.api.list', compact('apilist'));
    }

    public function Create(){

        return view('admin.pages.api.add');
    }

    public function Store(Request $request){
        $data = $request->validate([
            'slug' => 'required',
            'assign' => 'required',
            'api_key' => 'required|unique:api,api_key',
            'api_secret' => 'required|unique:api,api_secret',
        ]);

        API::create($data);
        return redirect()->route('admin.apiaccess')->with('success', 'API is added successfully!');

    }

    public function Edit($id){

        $api = API::find($id);
        if (!$api) {
            return redirect()->back()->with('error', 'API not found.');
        }

        if( $api->status == 1){
            $api->status = 0;
        }else  {
            $api->status = 1;
        }
        $api->save();

        return redirect()->back()->with('success', 'API status updated successfully.');
    }

    public function getProductlist(Request $request){

        if($request->api_key != null && $request->api_secret != null){
            $api_credential = API::where('api_key', $request->api_key)
                ->where('api_secret', $request->api_secret)
                ->where('status', 1)
                ->first();

            if($api_credential){
                if ($request->category == null) {
                    $products = Product::with('brand','category','colors','sizes')->get();
                    $data = [];
                    if($products){
                        foreach ($products as $product) {
                            $item = [
                                'id' => $product->id,
                                'image' => 'https://malakofftraders.com/uploaded_files/product_image/'.$product->Primary_Image,
                                'name' => $product->en_Product_Name,
                                'description' => $product->en_Description,
                                'price' => $product->Price,
                                'brand' => $product->brand->en_BrandName,
                                'category' => $product->category->en_Category_Name,
                                'colors' => $product->colors->pluck('Name'),
                                'sizes' => $product->sizes->pluck('Size'),
                            ];
                            $data[] = $item;
                        }
                        return response()->json($data);
                    } else { return response()->json(['message' => 'Product Not Found, Check URL'], 401); }

                } elseif( $request->category != null) {
                    $category = Category::where('en_Category_Slug',$request->category)->first();
                    if($category){
                        $products = Product::with('brand','category','colors','sizes')->where('category_id', $category->id)->get();
                    }else{ $products = null; }
                    $data = [];
                    if($products){
                        foreach ($products as $product) {
                            $item = [
                                'id' => $product->id,
                                'image' => 'https://malakofftraders.com/uploaded_files/product_image/'.$product->Primary_Image,
                                'name' => $product->en_Product_Name,
                                'description' => $product->en_Description,
                                'price' => $product->Price,
                                'brand' => $product->brand->en_BrandName,
                                'category' => $product->category->en_Category_Name,
                                'colors' => $product->colors->pluck('Name'),
                                'sizes' => $product->sizes->pluck('Size'),
                            ];
                            $data[] = $item;
                        }

                        return response()->json($data);
                    }else { return response()->json(['message' => 'Product Not Found, Check URL'], 401); }
                }
            }
            else {
                return response()->json(['message' => 'Invalid secret key or API key'], 401);
            }
        } else {
            return response()->json(['message' => 'Invalid secret key or API key'], 401);
        }
    }

    public function getStock(Request $request){

        if($request->api_key != null && $request->api_secret != null){
            $api_credential = API::where('api_key', $request->api_key)
                ->where('api_secret', $request->api_secret)
                ->where('status', 1)
                ->first();

            if($api_credential){

                $stocks= Stock::with('sizes','products')->latest()->get()->toArray();
                $categories = Category::all();
                $find = Stock::distinct()->pluck('product_id');
                $products = Product::with('stocks','sizes')->whereIn('id', $find)->get();

                if($products){

                    $data = [];
                    foreach ($products as $product) {
                        $sizesWithQuantities = [];

                        foreach ($product->sizes as $size) {
                            $quantity = null;

                            foreach ($product->stocks as $stock) {
                                if ($stock->size_id === $size->id) {
                                    $quantity = $stock->quantity;
                                    break;
                                }
                            }
                            $sizesWithQuantities [$size->Size] = $quantity;
                        }

                        $item = [
                            'product_id' => $product->id,
                            'image' => 'https://malakofftraders.com/uploaded_files/product_image/'.$product->Primary_Image,
                            'name' =>  $product->en_Product_Name,
                            'sizes' => $sizesWithQuantities,
                        ];

                        $data[] = $item;
                    }
                    return response()->json($data);
                } else { return response()->json(['message' => 'Stock Not Found, Check URL'], 401); }

            }
            else {
                return response()->json(['message' => 'Invalid secret key or API key is not matched'], 401);
            }
        } else {
            return response()->json(['message' => 'Invalid secret key or API key not found'], 401);
        }
    }

    public function getOrder(Request $request){

        if($request->api_key != null && $request->api_secret != null){

            $url = url()->current();
            if (strpos($url, 'order') !== false) {
                $api_credential = API::where('api_key', $request->api_key)
                    ->where('api_secret', $request->api_secret)
                    ->where('status', 1)
                    ->where('slug', 'order')
                    ->first();
            } else {
                return response()->json(['message' => 'Orders Not Found, Check URL'], 401);
            }


            if($api_credential){

                $orders = Order::with('order_details', 'user', 'designs', 'coupon', 'order_details.product', 'billing', 'shipping')->latest()->get()->toArray();

                if($orders){

                    $data = $orders;

                    return response()->json($data);
                } else { return response()->json(['message' => 'Orders Not Found, Check URL'], 401); }

            }
            else {
                return response()->json(['message' => 'Invalid secret key or API key is not matched'], 401);
            }
        } else {
            return response()->json(['message' => 'Invalid secret key or API key not found'], 401);
        }

    }


    // put functions start ---
    public function UpdateStock(Request $request){
        $sizes = [];
        $product_id = $request->input('product_id');
        $request_sizes = $request->except([
            '_token',
            'product_id',
        ]);

        foreach ($request_sizes as $key => $value){
            $size = getSizeId($key);
            $sizes [$size] = $value;
        }
        $total = 0;
        foreach ($sizes as $key => $value) {
            Stock::where('size_id', $key)->where('product_id',$product_id)->update(['quantity' => $value]);
            $total +=$value;
        }

        Product::where('id', $product_id)->update(['Quantity' => $total]);
        return response()->json(['message' => 'Quantity updated successfully']);
    }

    public function UpdateOrder(Request $request){

        $id = $request->order_id;
        if(is_null($request->Order_Status)) {
            return response()->json(['message' => 'Status is Required!']);
        }
        $order = Order::whereId($id)->first();

        if(!empty($order)) {

            $update = $order->update([
                'Order_Status' => $request->Order_Status,
            ]);

            if(! empty($request->shipping_method)) {
                $update = $order->update([
                    'shipping_method_tracking_id' => $request->tracking_id,
                    'shipping_method_id' => $request->shipping_method,
                ]);

                $this->statusChangeEmail($order, $request->Order_Status, $request->shipping_method, $request->tracking_id );
                return response()->json(['message' => 'Status successfully changed!']);

            } elseif (!empty($update)) {
                 $this->statusChangeEmail($order, $request->Order_Status);
                return response()->json(['message' => 'Status successfully changed!']);
            }

            return response()->json(['message' => 'Something went wrong!']);
        }

        return response()->json(['message' => 'Order not found!']);
    }

    public function statusChangeEmail($order, $order_status)
    {
        $ship = json_decode($order->shipping_address,true);
        $data['userName'] = $ship['name'];
        $data['userEmail'] = $ship['email'];
        $data['order'] = $order;
        $data['companyName'] = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
        $data['subject'] = __('Shipment Process');
        $data['data'] = $order_status;
        $data['template'] = 'email.order-status-change';
        dispatch(new OrderConfirmMail($data))->onQueue('email-send');
    }


}
