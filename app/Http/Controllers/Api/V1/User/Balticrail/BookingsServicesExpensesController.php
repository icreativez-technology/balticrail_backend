<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\BookingsServicesExpenses;
use App\Models\Balticrail\Bookings;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

#Request 
use App\Http\Requests\User\Balticrail\BookingsServicesExpenses\StoreRequest;
use App\Http\Requests\User\Balticrail\BookingsServicesExpenses\UpdateRequest;

class BookingsServicesExpensesController extends Controller
{
    public $pagination;

    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public function __construct()
    {
        $this->pagination = $this->pagination_count();
    }

    public function index($id)
    {
        $booking = Bookings::where('user_id','=',Auth::id())->find($id);
        
        $data = BookingsServicesExpenses::where('booking_id','=',$booking->id)->paginate($this->pagination);

        if(isset($booking->id))
        {
            $response = $data;
            $status = Response::HTTP_OK;
        }
        else
        {
            $response = [
                'message' => __('api.invalid_id'),
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;            
        }

        return response($response, $status);
    }

    public function save_booking_service_expense($data,$id = 0)
    {
        if($id > 0)
        {
            $record = BookingsServicesExpenses::find($id);
        }
        else
        {
            $record = new BookingsServicesExpenses();
            $record->booking_id = $data['booking_id'];
        }
       
        if(isset($data['service_code_id']) && !empty($data['service_code_id'])) {
            $record->service_code_id = $data['service_code_id'];
        } 

        if(isset($data['estimated_price']) && !empty($data['estimated_price'])) {
            $record->estimated_price = $data['estimated_price'];
        } 

        if(isset($data['quantity']) && !empty($data['quantity'])) {
            $record->quantity = $data['quantity'];
        }         

        if(isset($data['sum']) && !empty($data['sum'])) {
            $record->sum = $data['sum'];
        } 

        if(isset($data['description']) && !empty($data['description'])) {
            $record->description = $data['description'];
        } 
        
        if(isset($data['date']) && !empty($data['date'])) {
            $record->date = $data['date'];
        } 
        
        if(isset($data['invoice_id']) && !empty($data['invoice_id'])) {
            $record->invoice_id = $data['invoice_id'];
        } 
        
        return $record;
    }

    public function store(StoreRequest $request)
    {
        try
        {
            $data = $request->all();

            if(!isset($data['booking_id'])) 
            {
                $response = [
                    'message' => "Booking Id Is Missing"
                ];
    
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                return response($response, $status);                
            }

            $booking = $this->save_booking_service_expense($data);


            $response = [
                'message' => __('api.record_added'),
                'data' => $booking
            ];

            $status = Response::HTTP_OK;

            return response($response, $status);
        }
        catch(\Throwable $e) {
            $response = [
                'message' => $e->getMessage()
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }
    }

    public function show($id)
    {
        try
        {
            $booking = BookingsServicesExpenses::find($id);

            if(isset($booking->id))
            {
                $status = Response::HTTP_OK;

                $response = [
                    'booking' => $booking,
                ];
            }
            else
            {
                $response = [
                    'message' => __('api.invalid_id'),
                ];

                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            }

            return response($response, $status);
        }
        catch(\Throwable $e) {
            $response = [
                'message' => $e->getMessage()
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }
    }


    public function update(UpdateRequest $request, $id)
    {
        try
        {
            $data = $request->all();

            $booking = Bookings::where('user_id','=',Auth::id())->find($data['booking_id']);

            if(isset($booking->id))
            {
                $booking = BookingsServicesExpenses::where('booking_id','=',$booking->id)->find($id);

                if(isset($booking->id))
                {
                    $booking = $this->save_booking_service_expense($data,$id);

                    $response = [
                        'message' => __('api.record_updated'),
                        'data' => $booking
                    ];

                    $status = Response::HTTP_OK;
                }
                else
                {
                    $response = [
                        'message' => __('api.invalid_id'),
                    ];

                    $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                }
            }
            else
            {
                $response = [
                    'message' => __('api.invalid_id'),
                ];

                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            }                

            return response($response, $status);
        }
        catch(\Throwable $e) {
            $response = [
                'message' => $e->getMessage()
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }       
    }
}
