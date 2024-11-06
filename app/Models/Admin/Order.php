<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\Design;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'Order_Number',
        'User_Id',
        'Billing_Id',
        'Shipping_Id',
        'billing_address',
        'shipping_address',
        'Coupon_Id',
        'Coupon_Code',
        'Coupon_Amount',
        'Delivery_Charge',
        'Sub_Total',
        'Tax',
        'Grand_Total',
        'Is_Free_Delivery',
        'Is_Order_Successful',
        'Is_Order_Completed',
        'Payment_Method',
        'Payment_Status',
        'Order_Status',
        'Delivery_At',
        'txn',
        'shipping_method_tracking_id',
        'shipping_method_id',
    ];

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class, 'Order_Id');
    }
    public function designs()
    {
        return $this->hasMany(Design::class, 'order_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'User_Id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'Coupon_Id');
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'Billing_Id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'Shipping_Id');
    }
}
