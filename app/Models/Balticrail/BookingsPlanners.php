<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsPlanners extends Model
{
    protected $connection = 'balticrail';

    use HasFactory;

    public function booking()
    {
        return $this->belongsTo('App\Models\Balticrail\Bookings','booking_id','id');
    }

}
