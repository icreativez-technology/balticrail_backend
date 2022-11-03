<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\BookingsConditions;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

#Request 
use App\Http\Requests\User\Balticrail\BookingsConditions\StoreRequest;
use App\Http\Requests\User\Balticrail\BookingsConditions\UpdateRequest;
use App\Models\Balticrail\Bookings;
use App\Models\Balticrail\BookingsConditionsDamagedDetails;

class BookingsConditionsController extends Controller
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
        
        $data = BookingsConditions::where('booking_id','=',$booking->id)->paginate($this->pagination);

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

    public function save_bookings_conditions($data,$booking_id)
    {
        if($booking_id > 0)
        {
            $record = BookingsConditions::where('booking_id','=',$booking_id)->first();
        }
        else
        {
            $record = new BookingsConditions();
            $record->booking_id = $data['booking_id'];
        }
        
        if(isset($data['number_id']) && !empty($data['number_id'])) {
            $record->number_id = $data['number_id'];
        }

        if(isset($data['condition_type']) && !empty($data['condition_type'])) {
            $record->condition_type = $data['condition_type'];
        }

        if(isset($data['condition_class']) && !empty($data['condition_class'])) {
            $record->condition_class = $data['condition_class'];
        }        

        $record->save();
        
        return $record;
    }

    public function save_bookings_conditions_damaged_details($data,$booking_id,$booking_condition_id) 
    {
        //Delete Before add new
        BookingsConditionsDamagedDetails::where('booking_id','=',$booking_id)->delete();

        foreach($data['condition_damaged_details'] as $value)
        {
            $record = new BookingsConditionsDamagedDetails();
            $record->booking_id = $booking_id;
            $record->booking_condition_id = $booking_condition_id;

            if(isset($value['outside_or_inside']) && !empty($value['outside_or_inside'])) {
                $record->outside_or_inside = $value['outside_or_inside'];
            }    

            if(isset($value['damage_type']) && !empty($value['damage_type'])) {
                $record->damage_type = $value['damage_type'];
            }    

            $record->save();
        }        
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

            $booking_condition = $this->save_bookings_conditions($data,$data['booking_id']);
            $this->save_bookings_conditions_damaged_details($data,$data['booking_id'],$booking_condition->id);

            $response = [
                'message' => __('api.record_added'),
                'data' => $booking_condition
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
            $booking = BookingsConditions::find($id);

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
                $booking = BookingsConditions::where('booking_id','=',$booking->id)->find($id);

                if(isset($booking->id))
                {
                    $booking = $this->save_bookings_conditions($data,$id);

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
