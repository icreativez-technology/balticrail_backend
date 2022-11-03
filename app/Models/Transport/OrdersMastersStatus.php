<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersMastersStatus extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    protected $table = "orders_masters_status";
}
