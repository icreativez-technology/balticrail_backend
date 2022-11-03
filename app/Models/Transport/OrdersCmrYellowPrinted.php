<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersCmrYellowPrinted extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    protected $table = "orders_cmr_yellow printed";
}
