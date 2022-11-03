<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $connection = 'balticrail';
    protected $with = ['train_booking'];
    protected $appends = ['total_tue'];
    use HasFactory;

    protected $casts = [
        'departure_date'  => 'date:d.m.y'
        ];

    public function vehicle_type()
    {
        return $this->belongsTo('App\Models\Balticrail\VehiclesTypes','vehicle_type_id','id');
    }

    public function train_week(){
        return $this->belongsTo(Week::class,'week_id','id');
    }

    public function train_booking(){
        return $this->hasMany(TrainBooking::class,"train_id");
    }


    public function getTotalTueAttribute()
    {
        $twenty_fit_containers = [];
        $forty_fit_containers  = [];
        $total_tue = 0;

        $train_tues = $this->train_booking()->get();
        
        if(isset($train_tues)){
            foreach($train_tues as $tue){
                if($tue['tue'] == 20)
                {
                  $twenty_fit_containers[] = $tue['tue']; 
                }if($tue['tue'] >= 40){
                  $forty_fit_containers[] =  $tue['tue']; 
                } 
            }
            $total_tue = (count($twenty_fit_containers)+count($forty_fit_containers)*2);
        }

        return $total_tue;
    }

}
