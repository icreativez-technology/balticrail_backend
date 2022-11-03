<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\Balticrail\BookingsGateInExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class BookingsGateInController extends Controller
{
    public function index($booking_id) 
    {
        if(empty($booking_id)) 
        {
            $response = [
                'message' => "Booking Id Is Missing"
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);                
        }

        return Excel::download(new BookingsGateInExport($booking_id), 'gate_in.xlsx');
    }
}
