<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;

use App\Models\Balticrail\Bookings;

trait BalticrailTrait
{
    public function user_id()
    {
        return Auth::guard('balticrail')->id();
    }

    public function verify_user_booking_id($booking_id)
    {
        $user_id = $this->user_id;
		$booking = Bookings::where('user_id','=',$user_id)->find($booking_id);
        return isset($booking->id) ? $booking->id : 0;
    }
}
