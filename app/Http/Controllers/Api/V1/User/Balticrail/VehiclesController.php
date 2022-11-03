<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\Vehicles;
use App\Models\Balticrail\Week;
#Request 
use App\Http\Requests\User\Vehicles\StoreRequest;
use App\Http\Requests\User\Vehicles\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;
use App\Models\Balticrail\Bookings;
use App\Models\Balticrail\TrainBooking;
use App\Models\Balticrail\User;

class VehiclesController extends Controller
{
    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public $user_id;
    public $pagination;

    public function __construct()
    {
        $this->user_id = Auth::id();
        $this->pagination = $this->pagination_count();
    }
    
    public function index()
    {

        $data = Vehicles::with('vehicle_type')->paginate($this->pagination);
        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $record = new Vehicles;
        $record->name = $data['name'];
        $record->number = $data['number'];
        $record->vehicle_type_id = $data['vehicle_type_id'];
        $record->description = $data['description'];
        $record->save();

        $response = [
            'message' => __('api.record_added'),
            'data' => $record
        ];

        $status = Response::HTTP_OK;

        return response($response, $status);
    }

    public function show($id)
    {
        $record = Vehicles::find($id);

        if(isset($record->id))
        {
            $response = $record;
            $status = Response::HTTP_OK;
        }
        else
        {
            $response = [
                'message' => __('api.invalid_id')
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response($response, $status);
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();

        $record = Vehicles::where('id','=',$id)->first();

        if(isset($record->id))
        {
            $record->number = $data['number'];
            $record->vehicle_type_id = $data['vehicle_type_id'];
            $record->description = $data['description'];
            $record->save();

            $response = [
                'message' =>  __('api.record_updated'),
                'data' => $record
            ];  
        }
        else
        {
            $response = [
                'message' => __('api.invalid_id'),
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        $status = Response::HTTP_OK;

        return response($response, $status);
    }


    public function destroy($id)
    {
        $record = Vehicles::where('id','=',$id)->first();

        if(isset($record->id))
        {
            $record->delete();

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


    public function lookup(Request $request)
    {
        $bookingIds = TrainBooking::distinct()->pluck('booking_id');
        $userIds    = Bookings::whereIn('id',$bookingIds)->distinct()->pluck('user_id');
        $weeks      = Week::with('trains')->get();
        $trains     = Vehicles::with('train_week')->where('vehicle_type_id',3)->get();
        $clients    = User::whereIn('id',$userIds)->get();
        $weeksFilter = [];
        foreach($weeks as $week){
            $weeksFilter[] = $week;
        }
        $response = array(
            "weeks"         =>$weeks,
            'weeks_filter'  =>$weeksFilter,
            "trains"        =>$trains,
            'clients'       =>$clients
        );
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

}