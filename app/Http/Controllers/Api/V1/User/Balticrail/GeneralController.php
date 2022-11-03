<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Balticrail\Week;
use App\Models\Balticrail\Containers;
use App\Models\Balticrail\VehiclesTypes;
use App\Models\Balticrail\Partners;
use App\Models\Balticrail\Terminals;
use App\Models\Balticrail\Vehicles;
use App\Models\Balticrail\Drivers;
use App\Models\Balticrail\v2\Bookings;
use App\Models\Balticrail\TrainBooking;


#Trait
use App\Http\Traits\CommonFunctionsTrait;
use PhpOffice\PhpSpreadsheet\Calculation\Web;

class GeneralController extends Controller
{
    use CommonFunctionsTrait;

    public $pagination;

    public function __construct()
    {
        $this->pagination = $this->pagination_count();
    }

    public function getWeeks()
    {
        $response = Week::all();
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function createWeek(Request $request)
    {
        $createWeek = Week::create($request->all());
        $response = [
            'message' => __('api.record_added'),
            'data' => $createWeek
        ];
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function updateWeek(Request $request)
    {
        $updateWeek = Week::where('id',$request->id)->update($request->all());
        $response = [
            'message' => __('api.record_updated'),
            'data' => $updateWeek
        ];
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function getBookingData(){

        $containers     = Containers::all();
        $vehicles_types = VehiclesTypes::all();
        $partners       = Partners::all();
        $terminals      = Terminals::all();
        $drivers        = Drivers::all();

        $response = array(
            "containers"     =>$containers,
            "vehicles_types" =>$vehicles_types,
            "partners"       =>$partners,
            "terminals"      =>$terminals,
            "drivers"        =>$drivers   
        );
        $status = Response::HTTP_OK;
        return response($response, $status);

    }

    public function getVehicles($id)
    {

        $response = Vehicles::where("vehicle_type_id",$id)->get();
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function getFilteredBookings(Request $request)
    {

        $search = $request->search;
        $bookingIds = TrainBooking::distinct()->pluck('booking_id');
        if(isset($request->filter) &&  $request->filter == "all"){
            $data = Bookings::whereHas('user',function($query)use($search){
                $query->where('name', 'like', '%' .$search. '%');
            })->with('goods')
            ->orWhere('booking_display_id', 'like', '%' .$search. '%')
            ->orWhere('container_number', 'like', '%' .$search. '%')
            ->orWhere('week_number', 'like', '%' .$search. '%')
            ->orWhere('reference_number', 'like', '%' .$search. '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->pagination);
            $response = $data;
            return $response;
        }
        if(isset($request->filter) &&  $request->filter == "planned"){
            $data = Bookings::with('goods')->whereIn('booking_display_id',$bookingIds)
            ->where(function($query) use($search){
                $query->orWhere('container_number', 'like', '%' .$search. '%')
                ->orWhere('week_number', 'like', '%' .$search. '%')
                ->orWhere('reference_number', 'like', '%' .$search. '%')
                ->orWhere('booking_display_id', 'like', '%' .$search. '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->pagination);
            $response = $data;
            return $response;
        }
        if(isset($request->filter) &&  $request->filter == "unplanned"){
            //return "OKK";
            $data = Bookings::with('goods')
            ->whereNotIn('booking_display_id',$bookingIds)
            ->where(function($query) use($search){
                $query->orWhere('container_number', 'like', '%' .$search. '%')
                ->orWhere('week_number', 'like', '%' .$search. '%')
                ->orWhere('reference_number', 'like', '%' .$search. '%')
                ->orWhere('booking_display_id', 'like', '%' .$search. '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->pagination);
            $response = $data;
            return $response;
        }

        else{
            $data = Bookings::with('user','goods')
            ->paginate($this->pagination);
            $response = $data;
        }

        $status = Response::HTTP_OK;
        return response($response, $status);
    }


    public function getFilteredTrainBooking(Request $request)
    {
        $clients  = $request->clients;
        $trains   = $request->trains;
        $weeks    = $request->weeks;

        $data    = Week::with('trains');
        $query = null;
        if ($trains) {
            $query =  Week::with(['trains' =>function($query)use($trains) {
                $query->whereIn('name',$trains);
            }]);
        }
        if ($clients) {
            $bookingIds = Bookings::whereIn('user_id',$clients)->pluck('id');
            $query =  Week::with(['trains.train_booking' =>function($query)use($bookingIds) {
                $query->whereIn('booking_id',$bookingIds);
            }]);
        }
        if($weeks) {
            if($query) {
                $query = $query->whereIn('name',$weeks);
            } else {
                $query = Week::whereIn('name',$weeks)->with('trains')->whereIn('name',$weeks);
            }
        }
        if($request->direction) {
            $query =  Week::orWhere('name',$weeks)->with(['trains' =>function($query)use($request) {
                $query->whereIn('direction',$request->direction);
            }])->whereHas('trains',  function($query)use($request) {
                $query->whereIn('direction',$request->direction);
            });
        }


        $response  = isset($query) ? $query->get() : $data->get();
        $status = Response::HTTP_OK;
        return response($response, $status);
    }
}
