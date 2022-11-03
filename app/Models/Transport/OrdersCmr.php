<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersCmr extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    protected $table = "orders_cmr";

    public function cmr_detail()
    {
        return $this->hasMany('App\Models\Transport\OrdersCmrDetails','order_cmr_id','id');
    }
}
