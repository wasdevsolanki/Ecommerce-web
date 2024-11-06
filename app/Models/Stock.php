<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;
use App\Models\Admin\Size;

class Stock extends Model
{
    use HasFactory; 

    protected $fillable=[ 
        'product_id',
        'size_id',
        'quantity',
    ]; 

    public function sizes()
    {
        return $this->hasMany(Size::class, 'id','size_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class,'id','product_id');
    }
}
