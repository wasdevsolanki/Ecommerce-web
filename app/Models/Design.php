<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\OrderDetails;
use App\Models\Admin\Order;
use App\Models\Admin\Product;

class Design extends Model
{
    use HasFactory;
    protected $fillable=[
        'design_image',
        'uploaded_image',
        'product_color',
        'print_type',
        'instruction',
        'product_id',
        'user_id',
        'order_id',
        'Status',
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id','product_id');
    }
}
