<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\BookingsGoods;
use App\Models\Balticrail\Bookings;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

#Request 
use App\Http\Requests\User\Balticrail\BookingsGoods\StoreRequest;
use App\Http\Requests\User\Balticrail\BookingsGoods\UpdateRequest;

class BookingsGoodsController extends Controller
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
        
        $data = BookingsGoods::where('booking_id','=',$booking->id)->paginate($this->pagination);

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

    public function save_booking_goods($data,$id = 0)
    {
        if($id > 0)
        {
            $record = BookingsGoods::find($id);
        }
        else
        {
            $record = new BookingsGoods();
            $record->booking_id = $data['booking_id'];
        }
        
        if(isset($data['empty_or_loaded']) && !empty($data['empty_or_loaded'])) {
            $record->empty_or_loaded = $data['empty_or_loaded'];
        }   
        
        if(isset($data['size_type']) && !empty($data['size_type'])) {
            $record->size_type = $data['size_type'];
        }   

        if(isset($data['container_net']) && !empty($data['container_net'])) {
            $record->container_net = $data['container_net'];
        }   

        if(isset($data['container_tare']) && !empty($data['container_tare'])) {
            $record->container_tare = $data['container_tare'];
        }   

        if(isset($data['container_gross']) && !empty($data['container_gross'])) {
            $record->container_gross = $data['container_gross'];
        }   

        if(isset($data['vgm']) && !empty($data['vgm'])) {
            $record->vgm = $data['vgm'];
        }   

        if(isset($data['extra_time']) && !empty($data['extra_time'])) {
            $record->extra_time = $data['extra_time'];
        }   

        if(isset($data['description']) && !empty($data['description'])) {
            $record->description = $data['description'];
        }           

        $record->save();
        
        return $record;
    }

    public function store(StoreRequest $request)
    {
        //dd($request->all());
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

            $booking = $this->save_booking_goods($data);

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
            $booking = BookingsGoods::find($id);

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
            $updateBookingGoods = BookingsGoods::where('booking_id',$id)->update($request->all());
            if(isset($updateBookingGoods)){
                $response = [
                    'message' => __('api.record_updated'),
                    'data' => $updateBookingGoods
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
            // $data = $request->all();

            // $booking = Bookings::where('user_id','=',Auth::id())->find($data['booking_id']);

            // if(isset($booking->id))
            // {
            //     $booking = BookingsGoods::where('booking_id','=',$booking->id)->find($id);

            //     if(isset($booking->id))
            //     {
            //         $booking = $this->save_booking_goods($data,$id);

            //         $response = [
            //             'message' => __('api.record_updated'),
            //             'data' => $booking
            //         ];

            //         $status = Response::HTTP_OK;
            //     }
            //     else
            //     {
            //         $response = [
            //             'message' => __('api.invalid_id'),
            //         ];

            //         $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            //     }
            // }
            // else
            // {
            //     $response = [
            //         'message' => __('api.invalid_id'),
            //     ];

            //     $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            // }                

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
