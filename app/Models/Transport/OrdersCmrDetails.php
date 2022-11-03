<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersCmrDetails extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    protected $table = "orders_cmr_details";

    public function user(){
        return $this->belongsTo(User::class,'sender','id');
    }
}
