<?php

namespace App\Models\Balticrail\v2;

use App\Models\Balticrail\BookingsGoods;
use App\Models\Balticrail\BookingsTypes;
use App\Models\Balticrail\Containers;
use App\Models\Balticrail\Drivers;
use App\Models\Balticrail\Partners;
use App\Models\Balticrail\Terminals;
use App\Models\Balticrail\User;
use App\Models\Balticrail\Vehicles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;
    protected $table = "bookinggs";

    protected $with  = ['user'];
    protected $casts = [
        'created_at'  => 'date:d.m.y'
    ];

    protected $fillable = [
        'booking_display_id',
        'user_id',
        'container_owner_id',
        'cargo_owner_id',
        'forwarder_id',
        'terminal_id',
        'booking_type_id',
        'train_start_id',
        'train_end_id',
        'carrier_in_id',
        'transport_type_id',
        'receiver_id',
        'pickup_id',
        'drop_of_id',
        'drop_of_date',
        'carrier_out_id',
        'driver_id',
        'transport_out_id',
        'booking_type',
        'order_date',
        'week_number',
        'container_number',
        'seal',
        'adr',
        'gate_in_date',
        'reference_number',
        'door_date',
        'cc_address',
        'door_delivery',
        'truck_number',
        'overtime',
        'truck_leaving_date',
        'truck_returning_date',
        'comments',
        'is_planned'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    // public function booking_type()
    // {
    //     return $this->belongsTo(BookingsTypes::class,'booking_type_id','id');
    // }

    public function goods()
    {
        return $this->hasOne(BookingsGoods::class,'booking_id','booking_display_id');
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
