<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Admin\Product;
use App\Models\Admin\Size;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
 
class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks= Stock::with('sizes','products')->latest()->get()->toArray();
        $categories = Category::all();
        $find = Stock::distinct()->pluck('product_id');
        $products = Product::with('stocks','sizes')->whereIn('id', $find)->get();

        return view('admin.pages.stock.list',compact('stocks','categories','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product = Product::with('stocks','sizes')->where('id',$id)->first();
        $stock = Stock::with('products','sizes')->where('product_id',$id)->get();

        return view('admin.pages.stock.edit', compact('product','stock'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStockRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStockRequest  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $keys = [];
        $values = [];
        $total = 0;
        foreach ($request->all() as $key => $value) {
            if($key != '_token' && $key != 'id'){
                Stock::where('id', $key)->where('product_id',$request->id)->update(['quantity' => $value]);
                $total +=$value;
            }
        }
        Product::where('id', $request->id)->update(['Quantity' => $total]);

        return redirect()->route('admin.stock')->with('toast_success', __('Successfully Updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }

    public function getProducts(Request $request){
        $categories = Category::all();
        $categoryId = $request->input('category');
        $find = Stock::distinct()->pluck('product_id');
        $products = Product::with('stocks','sizes')->whereIn('id', $find)->whereCategoryId(request()->category)->get();
        
        return response()->json(['products' => $products]);
    }

    public function EditStockAPI(Request $request){

        return redirect()->back();
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



















}
