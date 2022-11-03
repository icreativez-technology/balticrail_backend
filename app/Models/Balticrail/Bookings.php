<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $connection = 'balticrail';

    use HasFactory;

    protected $with  = ['user'];
    protected $casts = [
        'created_at'  => 'date:d.m.y'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function booking_type()
    {
        return $this->belongsTo(BookingsTypes::class,'id','booking_id');
    }

    public function goods()
    {
        return $this->belongsTo(BookingsGoods::class,'booking_display_id','booking_id');
    }

    public function container_owner()
    {
        return $this->belongsTo(Partners::class,'container_owner_id','id');
    }

    public function cargo_owner()
    {
        return $this->belongsTo(Partners::class,'cargo_owner_id','id');
    }

    public function forwarder()
    {
        return $this->belongsTo(Partners::class,'forwarder_id','id');
    }

    public function trucking_company_in()
    {
        return $this->belongsTo(Partners::class,'trucking_company_in_id','id');
    }

    public function transport_first()
    {
        return $this->hasOne(Vehicles::class,'id','transport_first_id');
    }

    public function transport_second()
    {
        return $this->hasOne(Vehicles::class,'id','transport_second_id');
    }

    public function driver()
    {
        return $this->hasOne(Drivers::class,'id','driver_id');
    }

    public function trucking_company_out()
    {
        return $this->belongsTo(Partners::class,'trucking_company_out_id','id');
    }

    public function receiver()
    {
        return $this->belongsTo(Partners::class,'receiver_id','id');
    }
    
    public function terminal()
    {
        return $this->belongsTo(Terminals::class,'terminal_type_id','id');
    }

    public function container()
    {
        return $this->belongsTo(Containers::class,'container_id','id');
    }

}
