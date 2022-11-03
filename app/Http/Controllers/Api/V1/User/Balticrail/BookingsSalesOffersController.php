<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\BookingsSalesOffers;
use App\Models\Balticrail\Bookings;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

#Request 
use App\Http\Requests\User\Balticrail\BookingsSalesOffers\StoreRequest;
use App\Http\Requests\User\Balticrail\BookingsSalesOffers\UpdateRequest;

class BookingsSalesOffersController extends Controller
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
        
        $data = BookingsSalesOffers::where('booking_id','=',$booking->id)->paginate($this->pagination);

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

    public function save_booking_service_service($data,$id = 0)
    {
        if($id > 0)
        {
            $record = BookingsSalesOffers::find($id);
        }
        else
        {
            $record = new BookingsSalesOffers();
            $record->booking_id = $data['booking_id'];
        }
        
        if(isset($data['offer_number']) && !empty($data['offer_number'])) {
            $record->offer_number = $data['offer_number'];
        } 

        if(isset($data['rail']) && !empty($data['rail'])) {
            $record->rail = $data['rail'];
        } 

        if(isset($data['lift']) && !empty($data['lift'])) {
            $record->lift = $data['lift'];
        }         

        if(isset($data['trucking']) && !empty($data['trucking'])) {
            $record->trucking = $data['trucking'];
        } 

        if(isset($data['total']) && !empty($data['total'])) {
            $record->total = $data['total'];
        } 
        
        if(isset($data['vgm']) && !empty($data['vgm'])) {
            $record->vgm = $data['vgm'];
        } 
        
        if(isset($data['adr_imp']) && !empty($data['adr_imp'])) {
            $record->adr_imp = $data['adr_imp'];
        } 

        if(isset($data['t1']) && !empty($data['t1'])) {
            $record->t1 = $data['t1'];
        } 
        
        if(isset($data['tcc']) && !empty($data['tcc'])) {
            $record->tcc = $data['tcc'];
        } 
        
        if(isset($data['heavy_type']) && !empty($data['heavy_type'])) {
            $record->heavy_type = $data['heavy_type'];
        } 

        if(isset($data['heavy']) && !empty($data['heavy'])) {
            $record->heavy = $data['heavy'];
        } 

        if(isset($data['lump_sum']) && !empty($data['lump_sum'])) {
            $record->lump_sum = $data['lump_sum'];
        } 

        $record->save();
        
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

            $booking = $this->save_booking_service_service($data);


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
            $booking = BookingsSalesOffers::find($id);

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
                $booking = BookingsSalesOffers::where('booking_id','=',$booking->id)->find($id);

                if(isset($booking->id))
                {
                    $booking = $this->save_booking_service_service($data,$id);

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
