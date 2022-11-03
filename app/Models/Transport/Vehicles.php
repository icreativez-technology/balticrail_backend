<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    public function vehicle_type()
    {
        return $this->belongsTo('App\Models\Transport\VehiclesTypes','vehicle_type_id','id');
    }

}
