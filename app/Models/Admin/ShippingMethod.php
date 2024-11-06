<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    // The table associated with the model
    protected $table = 'shipping_methods';

    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'status',
    ];
}
 