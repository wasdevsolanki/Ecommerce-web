<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ShippingMethod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ShippingMethodController extends Controller
{
    //
    public function index(){
        $shipping_methods = ShippingMethod::get();
        return view('admin.pages.shipping_method.list', compact('shipping_methods'));
    }

    public function create(){
        return view('admin.pages.shipping_method.add');
    }

    public function store( Request $request ){

        $request->validate([
            'name' => 'required|unique:shipping_methods',
            'image' => 'required|image|mimes:png,jpg',
            'url' => 'required'
        ]);

        if (!empty($request->image)) {
            $LogoImageName = fileUpload($request['image'], ShippingMethodImage());
        }

        $method = new ShippingMethod();
        $method->image = $LogoImageName;
        $method->name = $request->name;
        $method->url = $request->url;
        $method->save();

        return redirect()->route('admin.shipping-method.index')->with('toast_success', __('Successfully Method Created!'));
    }

    public function update($id){

        // Find the template by its ID
        $method = ShippingMethod::find($id);

        if (!$method) {
            // Template not found, handle the error as needed (e.g., redirect back with an error message)
            return redirect()->back()->with('error', 'Shipping Method not found.');
        }

        if( $method->status == 1){
            $method->status = 0;
        }else  {
            $method->status = 1;
        }
        // Update the status to "active"
        $method->save();

        // Redirect back with a success message or perform any other action as needed
        return redirect()->back()->with('success', 'Shipping Method status updated successfully.');
    }
}
