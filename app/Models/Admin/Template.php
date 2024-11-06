<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    // The table associated with the model
    protected $table = 'product_templates';

    use HasFactory;
    protected $fillable = [
        'image',
        'product_type',
        'Status',
    ];
}
 