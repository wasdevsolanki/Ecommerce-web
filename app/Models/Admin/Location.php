<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // The table associated with the model
    protected $table = 'location_access';

    use HasFactory;
    protected $fillable = [
        'city',
        'country',
        'countryCode',
        'region',
        'zip',
        'status',
    ];
}
