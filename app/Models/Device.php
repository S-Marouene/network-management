<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'type',
        'description',
        'status',
        'ip_address',
        'model',
        'serial_number',
    ];
}
