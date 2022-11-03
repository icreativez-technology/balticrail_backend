<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsGoods extends Model
{
    use HasFactory;
    protected $connection = 'balticrail';

    protected $fillable  = [
        'booking_id',
        'empty_or_loaded',
        'size_type',
        'container_net',
        'container_tare',
        'container_gross',
        'vgm',
        'extra_time',
        'description',
    ];

    protected $guarded = [];
    
}
