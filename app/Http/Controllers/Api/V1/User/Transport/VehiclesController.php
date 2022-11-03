<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\Vehicles;

#Request 
use App\Http\Requests\User\Transport\Vehicles\StoreRequest;
use App\Http\Requests\User\Transport\Vehicles\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

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

    public function store(StoreRequest $request)
    {
        $data = $request->all();

        $record = new Vehicles;
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
        $records = Vehicles::get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }
}