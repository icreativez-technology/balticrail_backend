<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

#Model
use App\Models\Balticrail\Bookings;
use App\Models\Balticrail\BookingsCmr;
use App\Models\Balticrail\BookingsCmrDetails;

#Request 
use App\Http\Requests\User\Balticrail\BookingsCmr\StoreRequest;
use App\Http\Requests\User\Balticrail\BookingsCmr\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class BookingsCmrController extends Controller
{
    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public $user_id;
    public $pagination;

    public function __construct()
    {
        $this->user_id = Auth::guard('balticrail')->id();
        $this->pagination = $this->pagination_count();
    }

    public function display_calendar()
    {
        $form_html =  view('user.balticrail.calendar')->render();
        return $form_html;
    }

    public function select_template($booking_id, Request $request)
    {
        if(empty($booking_id)) 
        {
            $response = [
                'message' => "Booking Id Is Missing"
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);                
        }

        $booking = Bookings::find($booking_id);

        $data = [
            'booking' => $booking,
        ];

        if($request->template == 3)
        {
            $customPaper = array( 0, 0, 790.866, 683.15);
            $pdf = PDF::loadView('user.balticrail.template_'.$request->template, $data)->setPaper($customPaper, 'landscape');
        }
        else
        {
            $pdf = PDF::loadView('user.balticrail.template_'.$request->template, $data);
        }
        
        if(isset($request->html) && $request->html == 1)
        {
            $form_html =  view('user.balticrail.template_'.$request->template)->with($data)->render();
            return $form_html;
        }
        
        return $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
    }
}
