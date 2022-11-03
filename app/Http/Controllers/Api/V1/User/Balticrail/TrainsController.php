<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\Trains;
use App\Models\Balticrail\Week;
use App\Models\Balticrail\Vehicles;
#Request 
use App\Http\Requests\User\Balticrail\Trains\StoreRequest;
use App\Http\Requests\User\Balticrail\Trains\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class TrainsController extends Controller
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
        $records = Trains::where('vehicle_type_id','=',3)->paginate($this->pagination);
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }


    public function store(StoreRequest $request)
    {   

       
        //dd($request->all());
        try 
        {
            $data = $request->all();

            $record = new Trains();
            $record->name = $data['name'];
            $record->number = $data['number'];
            $record->description = $data['description'];
            $record->week_id = $request->week;
            $record->direction = $request->direction;
            $record->departure_date = $request->departure_date;
            $record->vehicle_type_id = 3; // Train
            $record->save();
            $weeks  = Week::with('trains')->get();
            $trains = Vehicles::with('train_week')->where('vehicle_type_id',3)->get();
            $record = array(
                "weeks"  =>$weeks,
                "trains" =>$trains 
            );
            $response = [
                'message' => __('api.record_added'),
                'data' => $record
            ];

            $status = Response::HTTP_OK;

            return response($response, $status);
        }
        catch(\Throwable $e) {


            $response = [
                'tech' => $this->tech_error($e),
                'message' => __('api.server_issue')
            ];


            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }            
    }

    public function show($id)
    {
        try
        {
            $record = Trains::find($id);
 
            if(isset($record->id))
            {
                $status = Response::HTTP_OK;
                $response = $record;
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
        catch(\Throwable $e) {

            $response = [
                'tech' => $this->tech_error($e),
                'message' => __('api.server_issue')
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }
    }


    public function update(UpdateRequest $request,$id)
    {
        try 
        {
            $data = $request->all();

            $record = Trains::find($id);

            if(isset($record->id))
            {            
                $record->name = $data['name'];
                $record->number = $data['number'];
                $record->description = $data['description'];
                $record->week_id = $request->week;
                $record->direction = $request->direction;
                $record->departure_date = $request->departure_date;
                $record->vehicle_type_id = 3; // Train
                $record->update();

                $response = [
                    'message' =>  __('api.record_updated'),
                    'data' => $record
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
                'tech' => $this->tech_error($e),
                'message' => __('api.server_issue')
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }

    }

    public function destroy($id)
    {
        $record = Trains::where('id','=',$id)->first();

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
        $records = Trains::get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

}