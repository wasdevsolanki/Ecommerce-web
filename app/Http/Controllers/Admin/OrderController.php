<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\OrderConfirmMail;
use App\Models\Admin\Order;
use App\Models\Admin\Product;
use App\Models\Admin\Color;
use App\Models\Design;
use App\Models\Admin\OrderDetails;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Crypt;



class OrderController extends Controller
{

    public function orders(Request $request, $status)
    {
        if($request->ajax()) {
            if ($status == 'pending') {
                $data = Order::where('Order_Status', ORDER_PENDING);
            }elseif($status == 'processing') {
                $data = Order::where('Order_Status', ORDER_PROCESSING);
            }elseif($status == 'shipped') {
                $data = Order::where('Order_Status', ORDER_SHIPPED);
            }elseif($status == 'delivered') {
                $data = Order::where('Order_Status', ORDER_DELIVERED);
            }elseif($status == 'returned') {
                $data = Order::where('Order_Status', ORDER_RETURN);
            }elseif($status == 'all') {
                $data = Order::query();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<div class="action__buttons">';
                    $btn = $btn.'<a href="javascript:void(0)" class="btn-action" data-bs-toggle="modal" data-bs-target="#invoiceModal'.$data->id.'" title="'.__('Invoice').'"><i class="fas fa-file-invoice"></i></a>';
                    $btn =$btn. '<a href="javascript:void(0)" class="btn-action" data-bs-toggle="modal" data-bs-target="#changeModal'.$data->id.'" title="'.__('Change Status').'"><i class="far fa-calendar-alt"></i></a>';
                    $btn =$btn. '<a href="'. route('admin.order_delete', encrypt($data->id)) .'" class="btn-action delete"><i class="fas fa-trash-alt"></i></a>';
                    $btn = $btn.'</div>';
                    return $btn;
                })
                ->addColumn('User', function ($data) {
                    return $data->user != null ?$data->user->name : __('Guest User');
                })
                ->addColumn('GrandTotal', function($data) {
                    return '$'.$data->Grand_Total;
                })


                ->addColumn('Design', function($data) {
                    $html = '';
                    foreach ($data->designs as $or) {
                        $html .= '<a href="'.route('admin.design_product', $or->id).'"><img src="'. asset('/uploaded_files/design/'. $or->design_image)  . '" border="0" height="50" class="img-rounded mr-1" align="center" /></a>';
                    }
                    return $html;
                })
                ->addColumn('Products', function ($data) {
                    $html = '';
                    foreach ($data->order_details as $or) {
                        $html .= '<img src="'. asset(IMG_PRODUCT_PATH. $or->product->Primary_Image)  . '" border="0" height="50" class="img-rounded mr-1" align="center" />';
                    }
                    return $html;
                })
                ->addColumn('types', function ($data) {
                    $html = '';
                    foreach ($data->order_details as $key => $or) {
                        if(count($data->order_details) - 1 == $key) {
                            if($or->product->type == PRODUCT_PHYSICAL) {
                                $html .= 'Physical';
                            }elseif($or->product->type == PRODUCT_DIGITAL) {
                                $html .= 'Digital';
                            }
                        }else {
                            if($or->product->type == PRODUCT_PHYSICAL) {
                                $html .= 'Physical,';
                            }elseif($or->product->type == PRODUCT_DIGITAL) {
                                $html .= 'Digital,';
                            }
                        }

                    }
                    return $html;
                })
                ->addColumn('Coupon', function($data) {
                    return is_null($data->Coupon_Id) ? 'N/A' : $data->coupon->CouponCode;
                })
                ->addColumn('digital_goods', function($data) {
                    if(validDigitalSend($data->id)) {
                        return '<a href="'.route('admin.digital_product_send', encrypt($data->id)).'" class="btn btn-outline-primary small rounded" title="'.__('Send').'">'.__('Send').'</a>';
                    }else {
                        return 'N/A';
                    }
                })
                ->addColumn('Status', function($data) {
                    $html = '';
                    if($data->Order_Status == ORDER_PENDING) {
                        $html = __('<span class="status bg-primary-light-varient">Pending</span>');
                    }elseif ($data->Order_Status == ORDER_PROCESSING) {
                        $html = __('<span class="status bg-secondary-light-varient">Processing</span>');
                    }elseif ($data->Order_Status == ORDER_SHIPPED) {
                        $html = __('<span class="status bg-info-light-varient">Shipped</span>');
                    }elseif ($data->Order_Status == ORDER_DELIVERED) {
                        $html = __('<span class="status bg-success-light-varient">Delivered</span>');
                    }elseif ($data->Order_Status == ORDER_CANCELLED) {
                        $html = __('<span class="status bg-danger-light-varient">Canceled</span>');
                    }elseif ($data->Order_Status == ORDER_RETURN) {
                        $html = __('<span class="status bg-danger-light-varient">Returned</span>');
                    }elseif ($data->Order_Status == ORDER_NOT_PAYMENT_YET) {
                        $html = __('<span class="status bg-warning-light-varient">Not Payment Yet</span>');
                    }elseif ($data->Order_Status == ORDER_DELIVERED_FAILED) {
                        $html = __('<span class="status bg-danger-light-varient">Delivery Failed</span>');
                    }
                    return $html;
                })
                ->rawColumns(['action', 'Products', 'Design', 'digital_goods', 'Status', 'types'])
                ->make(true);
        }
        $data['title'] = __('Order List');
        $data['status_prefix'] = $status;
        $data['orders'] = Order::with('order_details', 'user', 'designs', 'coupon', 'order_details.product', 'billing', 'shipping')->get();
        return view('admin.pages.orders.list',$data);
    }


    public function orderStatusChange(Request $request, $id)
    {
        $id = decrypt($id);
        if(is_null($request->Order_Status)) {
            return redirect()->back()->with('toast_error', __('Status is required!'));
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
                // Mail::to('wasdevdzn@gmail.com')->send(new SendMail());
                return redirect()->back()->with('toast_success', __('Status successfully changed!'));
            } elseif (!empty($update)) {
                $this->statusChangeEmail($order, $request->Order_Status);
                // Mail::to('wasdevdzn@gmail.com')->send(new SendMail());
                return redirect()->back()->with('toast_success', __('Status successfully changed!'));
            }

            return redirect()->back()->with('toast_error', __('Something went wrong!'));
        }
        return redirect()->back()->with('toast_error', __('Order not found!'));
    }


    public function orderStatusChangeApi(Request $request)
    {
        // return $this->orderStatusChange($request , $id);
        // $id = decrypt($request->id);
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
                 //Mail::to('wasdevdzn@gmail.com')->send(new SendMail());
                return response()->json(['message' => 'Status successfully changed!']);

            } elseif (!empty($update)) {
                $this->statusChangeEmail($order, $request->Order_Status);
                // Mail::to('wasdevdzn@gmail.com')->send(new SendMail());
                return response()->json(['message' => 'Status successfully changed!']);
            }

            return response()->json(['message' => 'Something went wrong!']);

        }
        return redirect()->back()->with('toast_error', __('Order not found!'));

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

    public function orderDelete($id)
    {
        $id = decrypt($id);
        $delete = Order::whereId($id)->delete();
        if(!empty($delete)) {
            OrderDetails::where('Order_Id', $id)->delete();
            return redirect()->back()->with('toast_success', __('Successfully deleted!'));
        }
        return redirect()->back()->with('toast_error', __('Something went wrong!'));
    }

    public function transactionsList(Request $request)
    {
        if($request->ajax()) {
            $data = Order::where('Payment_Method', '!=', COD);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_email', function ($data) {
                    $email = json_decode($data->billing_address, true);
                    return $email['email'];
                })
                ->addColumn('GrandTotal', function($data) {
                    return '$'.$data->Grand_Total;
                })
                ->addColumn('status', function($data) {
                    $html = '';
                    if($data->Order_Status == ORDER_PENDING) {
                        $html = __('<span class="status bg-primary-light-varient">Pending</span>');
                    }elseif ($data->Order_Status == ORDER_PROCESSING) {
                        $html = __('<span class="status bg-secondary-light-varient">Processing</span>');
                    }elseif ($data->Order_Status == ORDER_SHIPPED) {
                        $html = __('<span class="status bg-info-light-varient">Shipped</span>');
                    }elseif ($data->Order_Status == ORDER_DELIVERED) {
                        $html = __('<span class="status bg-success-light-varient">Delivered</span>');
                    }elseif ($data->Order_Status == ORDER_CANCELLED) {
                        $html = __('<span class="status bg-danger-light-varient">Canceled</span>');
                    }elseif ($data->Order_Status == ORDER_RETURN) {
                        $html = __('<span class="status bg-danger-light-varient">Returned</span>');
                    }elseif ($data->Order_Status == ORDER_NOT_PAYMENT_YET) {
                        $html = __('<span class="status bg-warning-light-varient">Not Payment Yet</span>');
                    }elseif ($data->Order_Status == ORDER_DELIVERED_FAILED) {
                        $html = __('<span class="status bg-danger-light-varient">Delivery Failed</span>');
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $data['title'] = __('All Transactions');
        return view('admin.pages.transactions.list',$data);
    }

    public function digitalProductSend($id)
    {
        $id = decrypt($id);
        $order = Order::whereId($id)->with('order_details', 'order_details.product')->first();
        if(!is_null($order)) {
            $data['title'] = __('Digital Product Send');
            $data['order'] = $order;
            return view('admin.pages.orders.digital-send', $data);
        }
        return redirect()->back()->with('toast_error', __('No order found'));
    }

    public function digitalProductMail(Request $request)
    {
        $data['userName'] = 'John Doe';
        $data['userEmail'] = $request->mail_address;
        $data['data'] = $request->link;
        $data['subject'] = __('Digital Product Send');
        $data['template'] = 'email.digital-product-send';
        dispatch(new OrderConfirmMail($data))->onQueue('email-send');
        return redirect()->back()->with('toast_success', __('Mail successfully send!'));
    }

    public function DesignProduct($id){
        $design = Design::with(['orders','product'])->where('id',$id)->first();
        $product = Product::where('id', $design->product_id)->first();
        $color = Color::where('Name', $design->product_color)->first();
        $order_details = OrderDetails::where('order_id',$design->order_id)->first();
        $sizes = json_decode($order_details->Sizes, true);

        return view('admin.pages.orders.single-product', compact('design', 'order_details', 'sizes','product','color'));
    }
}
