<?php

namespace App\Models\Balticrail;

use App\Models\Balticrail\v2\Bookings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class TrainBooking extends Model
{
    use HasFactory;

    protected $connection = 'balticrail';
    
    protected $fillable = ['train_id','booking_id','is_copied','old_id','new_id'];
    
    protected $with  = ['bookings','goods'];

    protected $appends  = ['tue'];

    public function bookings(){
        return $this->hasOne(Bookings::class,'booking_display_id','booking_id');
    }

    public function goods(){
        return $this->belongsTo(BookingsGoods::class,'booking_id','booking_id');
    }

    public function getTueAttribute()
    {
        $tue = $this->goods()->first();
        if($tue){
            return  intval($tue->size_type);
        }
    }
}
