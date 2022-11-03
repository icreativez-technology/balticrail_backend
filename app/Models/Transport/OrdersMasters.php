<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersMasters extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    public function order_type()
    {
        return $this->belongsTo('App\Models\Transport\OrdersTypes','order_type_id','id');
    }

    public function carrier_partner()
    {
        return $this->belongsTo('App\Models\Transport\Partners','carrier_partner_id','id');
    }

    public function truck()
    {
        return $this->hasOne('App\Models\Transport\Vehicles','id','truck_id')->where('vehicle_type_id','=',1);
    }

    public function trailer()
    {
        return $this->hasOne('App\Models\Transport\Vehicles','id','trailer_id')->where('vehicle_type_id','=',2);
    }
}
