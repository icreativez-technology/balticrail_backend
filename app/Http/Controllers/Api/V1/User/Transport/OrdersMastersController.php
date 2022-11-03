<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\OrdersMasters;

#Request 
use App\Http\Requests\User\Transport\OrdersMasters\StoreRequest;
use App\Http\Requests\User\Transport\OrdersMasters\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class OrdersMastersController extends Controller
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
        $records = OrdersMasters::with('carrier_partner')->with('truck')->with('trailer')->paginate($this->pagination);
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }


    public function show($id)
    {
        try
        {
            $record = OrdersMasters::find($id);
 
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

            $record = OrdersMasters::find($id);

            if(isset($record->id))
            {            
                $record->carrier_partner_id = isset($data['carrier_partner_id']) ? $data['carrier_partner_id'] : 0;
                $record->vehicle_type_id = isset($data['vehicle_type_id']) ? $data['vehicle_type_id'] : 0;
                $record->truck_id = isset($data['truck_id']) ? $data['truck_id'] : 0;
                $record->trailer_id = isset($data['trailer_id']) ? $data['trailer_id'] : 0;
                $record->status = isset($data['status']) ? $data['status'] : 0;
                $record->save();

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
        $record = OrdersMasters::where('id','=',$id)->first();

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

    public function get_new_order_id()
    {
        $latest_record = OrdersMasters::OrderBy('id','DESC')->first();

        $new_id = $latest_record->id + 1;

        $response = [
            'id' => "MID".$new_id
        ];

        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function lookup(Request $request)
    {
        $records = OrdersMasters::get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

}