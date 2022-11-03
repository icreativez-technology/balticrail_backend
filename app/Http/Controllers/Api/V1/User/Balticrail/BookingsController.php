<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\v2\Bookings;
use App\Models\Balticrail\TrainBooking;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

#Request 
use App\Http\Requests\User\Balticrail\Bookings\StoreRequest;
use App\Http\Requests\User\Balticrail\Bookings\UpdateRequest;


class BookingsController extends Controller
{
    public $pagination;

    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public function __construct()
    {
        $this->pagination = $this->pagination_count();
    }

    public function index(Request $request)
    {
        $bookingIds = TrainBooking::distinct()->pluck('booking_id');
        $bookings = Bookings::with('user','goods')->whereNotIn('booking_display_id',$bookingIds)
        ->orderBy('id', 'DESC')
        ->paginate($this->pagination);
        if(isset($request->filter) && $request->filter == "all"){
           $bookings = Bookings::with('user','goods')->orderBy('id', 'DESC')
            ->paginate($this->pagination);
        }
        $status = Response::HTTP_OK;
        return response($bookings, $status);
    }

    public function save_update_booking($value,$booking_id = 0)
    {
        if($booking_id > 0)
        {
            $record = Bookings::find($booking_id);
        }
        else
        {
            $record = new Bookings();
            $record->user_id = Auth::id();
        }
        
        if(isset($value['booking_stage']) && !empty($value['booking_stage'])) {
            $record->booking_stage = $value['booking_stage'];
        }

        if(isset($value['booking_zone']) && !empty($value['booking_zone'])) {
            $record->booking_zone = $value['booking_zone'];
        }

        if(isset($value['booking_display_id']) && !empty($value['booking_display_id'])) {
            $record->booking_display_id = $value['booking_display_id'];
        }

        if(isset($value['master_id']) && !empty($value['master_id'])) {
            $record->master_id = $value['master_id'];
        }

        if(isset($value['order_date']) && !empty($value['order_date'])) {
            $record->order_date = $value['order_date'];
        }

        if(isset($value['order_time']) && !empty($value['order_time'])) {
            $record->order_time = $value['order_time'];
        }

        if(isset($value['week_number']) && !empty($value['week_number'])) {
            $record->week_number = $value['week_number'];
        }

        if(isset($value['container_id']) && !empty($value['container_id'])) {
            $record->container_id = $value['container_id'];
        }

        if(isset($value['transport_type_id']) && !empty($value['transport_type_id'])) {
            $record->transport_type_id = $value['transport_type_id'];
        }

        if(isset($value['transport_first_id']) && !empty($value['transport_first_id'])) {
            $record->transport_first_id = $value['transport_first_id'];
        }

        if(isset($value['transport_second_id']) && !empty($value['transport_second_id'])) {
            $record->transport_second_id = $value['transport_second_id'];
        }

        if(isset($value['seal_id']) && !empty($value['seal_id'])) {
            $record->seal_id = $value['seal_id'];
        }

        if(isset($value['container_owner_id']) && !empty($value['container_owner_id'])) {
            $record->container_owner_id = $value['container_owner_id'];
        }

        if(isset($value['cargo_owner_id']) && !empty($value['cargo_owner_id'])) {
            $record->cargo_owner_id = $value['cargo_owner_id'];
        }

        if(isset($value['forwarder_id']) && !empty($value['forwarder_id'])) {
            $record->forwarder_id = $value['forwarder_id'];
        }

        if(isset($value['terminal_type_id']) && !empty($value['terminal_type_id'])) {
            $record->terminal_type_id = $value['terminal_type_id'];
        }
        
        if(isset($value['terminal_account']) && !empty($value['terminal_account'])) {
            $record->terminal_account = $value['terminal_account'];
        }
        
        if(isset($value['booking_type_id']) && !empty($value['booking_type_id'])) {
            $record->booking_type_id = $value['booking_type_id'];
        }        

        if(isset($value['reference_number']) && !empty($value['reference_number'])) {
            $record->reference_number = $value['reference_number'];
        }

        if(isset($value['gate_in_date']) && !empty($value['gate_in_date'])) {
            $record->gate_in_date = $value['gate_in_date'];
        }
        
        if(isset($value['gate_out_date']) && !empty($value['gate_out_date'])) {
            $record->gate_out_date = $value['gate_out_date'];
        }
        
        if(isset($value['gate_in_time']) && !empty($value['gate_in_time'])) {
            $record->gate_in_time = $value['gate_in_time'];
        }        
        
        if(isset($value['gate_out_time']) && !empty($value['gate_out_time'])) {
            $record->gate_out_time = $value['gate_out_time'];
        }

        if(isset($value['trucking_company_in_id']) && !empty($value['trucking_company_in_id'])) {
            $record->trucking_company_in_id = $value['trucking_company_in_id'];
        }

        if(isset($value['outgoing_date']) && !empty($value['outgoing_date'])) {
            $record->outgoing_date = $value['outgoing_date'];
        }   
        
        if(isset($value['outgoing_time']) && !empty($value['outgoing_time'])) {
            $record->outgoing_time = $value['outgoing_time'];
        }   
        
        if(isset($value['door_delivery']) && !empty($value['door_delivery'])) {
            $record->door_delivery = $value['door_delivery'];
        }   
        
        if(isset($value['door_date']) && !empty($value['door_date'])) {
            $record->door_date = $value['door_date'];
        }           

        if(isset($value['door_time']) && !empty($value['door_time'])) {
            $record->door_time = $value['door_time'];
        }           

        if(isset($value['door_transport_type_id']) && !empty($value['door_transport_type_id'])) {
            $record->door_transport_type_id = $value['door_transport_type_id'];
        }           

        if(isset($value['door_transport_first_id']) && !empty($value['door_transport_first_id'])) {
            $record->door_transport_first_id = $value['door_transport_first_id'];
        }           

        if(isset($value['door_transport_second_id']) && !empty($value['door_transport_second_id'])) {
            $record->door_transport_second_id = $value['door_transport_second_id'];
        }           

        if(isset($value['driver_out_id']) && !empty($value['driver_out_id'])) {
            $record->driver_out_id = $value['driver_out_id'];
        }           

        if(isset($value['trucking_company_out_id']) && !empty($value['trucking_company_out_id'])) {
            $record->trucking_company_out_id = $value['trucking_company_out_id'];
        }           

        if(isset($value['receiver_id']) && !empty($value['receiver_id'])) {
            $record->receiver_id = $value['receiver_id'];
        }           

        if(isset($value['pickup_id']) && !empty($value['pickup_id'])) {
            $record->pickup_id = $value['pickup_id'];
        }           

        if(isset($value['drop_off_id']) && !empty($value['drop_off_id'])) {
            $record->drop_off_id = $value['drop_off_id'];
        }           

        if(isset($value['drop_off_date']) && !empty($value['drop_off_date'])) {
            $record->drop_off_date = $value['drop_off_date'];
        }           

        if(isset($value['drop_off_time']) && !empty($value['drop_off_time'])) {
            $record->drop_off_time = $value['drop_off_time'];
        }           

        if(isset($value['cc_address']) && !empty($value['cc_address'])) {
            $record->cc_address = $value['cc_address'];
        }           

        if(isset($value['comments']) && !empty($value['comments'])) {
            $record->comments = $value['comments'];
        }           

        if(isset($value['overtime']) && !empty($value['overtime'])) {
            $record->overtime = $value['overtime'];
        }   

        if(isset($value['use_pantos_service']) && !empty($value['use_pantos_service'])) {
            $record->use_pantos_service = $value['use_pantos_service'];
        }           

        if(isset($value['pantos_service_delivery_id']) && !empty($value['pantos_service_delivery_id'])) {
            $record->pantos_service_delivery_id = $value['pantos_service_delivery_id'];
        }           

        if(isset($value['pantos_service_drop_off_id']) && !empty($value['pantos_service_drop_off_id'])) {
            $record->pantos_service_drop_off_id = $value['pantos_service_drop_off_id'];
        }   

        $record->save();
        
        if($booking_id == 0)
        {
            $record->booking_display_id = "ID".$record->id;
            $record->save();           
        }
        
        return $record;
    }

    public function store(StoreRequest $request)
    {

        try
        {
            $data = $request->all();

            $booking = $this->save_update_booking($data);

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
            $booking = Bookings::where('user_id','=',Auth::id())->find($id);

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

            $booking = Bookings::where('user_id','=',Auth::id())->find($id);

            if(isset($booking->id))
            {

                $data = $request->all();

                $booking = $this->save_update_booking($data,$id);

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

    public function destroy($id)
    {

    
        $booking = Bookings::where('user_id','=',Auth::id())->find($id);
        if(isset($booking->id))
        {
            $booking->delete();

            $response = [
                'message' => __('api.record_deleted'),
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

        return response($response, $status);
    }    

}
