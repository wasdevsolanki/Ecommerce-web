<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class API extends Model
{
    // The table associated with the model
    protected $table = 'api';

    use HasFactory;
    protected $fillable = [
        'slug',
        'api_key',
        'api_secret',
        'assign',
        'status',
    ];
}
