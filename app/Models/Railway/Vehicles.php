<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $connection = 'railway';

    use HasFactory;

    public function vehicle_type()
    {
        return $this->belongsTo('App\Models\Railway\VehiclesTypes','vehicle_type_id','id');
    }

}
