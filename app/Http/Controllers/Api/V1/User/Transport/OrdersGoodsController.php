<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\OrdersGoods;

#Request 
use App\Http\Requests\User\Transport\OrdersGoods\StoreRequest;
use App\Http\Requests\User\Transport\OrdersGoods\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;


class OrdersGoodsController extends Controller
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

    public function index($id)
    {
        $data = OrdersGoods::where('order_id','=',$id)->get();
        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $value = $request->all();

            $record = new OrdersGoods();
            $record->order_id = isset($value['order_id']) ? $value['order_id'] : 0;
            $record->pieces = isset($value['pieces']) ? $value['pieces'] : 0;
            $record->piece_type_id = isset($value['piece_type_id']) ? $value['piece_type_id'] : 0;
            $record->unit = isset($value['unit']) ? $value['unit'] : 0;
            $record->unit_type_id = isset($value['unit_type_id']) ? $value['unit_type_id'] : 0;
            $record->kg_calc = isset($value['kg_calc']) ? $value['kg_calc'] : 0;
            $record->cost = isset($value['cost']) ? $value['cost'] : 0;
            $record->ldm = isset($value['ldm']) ? $value['ldm'] : 0;
            $record->volume = isset($value['volume']) ? $value['volume'] : 0;
            $record->length = isset($value['length']) ? $value['length'] : 0;
            $record->weight = isset($value['weight']) ? $value['weight'] : 0;
            $record->height = isset($value['height']) ? $value['height'] : 0;
            $record->description = isset($value['description']) ? $value['description'] : "";
            $record->marks = isset($value['marks']) ? $value['marks'] : "";
            $record->save();

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
            $record = OrdersGoods::find($id);
 
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
            $value = $request->all();

            $record = OrdersGoods::find($id);

            if(isset($record->id))
            {                  
                $record->pieces = isset($value['pieces']) ? $value['pieces'] : 0;
                $record->piece_type_id = isset($value['piece_type_id']) ? $value['piece_type_id'] : 0;
                $record->unit = isset($value['unit']) ? $value['unit'] : 0;
                $record->unit_type_id = isset($value['unit_type_id']) ? $value['unit_type_id'] : 0;
                $record->kg_calc = isset($value['kg_calc']) ? $value['kg_calc'] : 0;
                $record->cost = isset($value['cost']) ? $value['cost'] : 0;
                $record->ldm = isset($value['ldm']) ? $value['ldm'] : 0;
                $record->volume = isset($value['volume']) ? $value['volume'] : 0;
                $record->length = isset($value['length']) ? $value['length'] : 0;
                $record->weight = isset($value['weight']) ? $value['weight'] : 0;
                $record->height = isset($value['height']) ? $value['height'] : 0;
                $record->description = isset($value['description']) ? $value['description'] : "";
                $record->marks = isset($value['marks']) ? $value['marks'] : "";
                $record->save();

                $response = [
                    'message' => __('api.record_updated'),
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
        $record = OrdersGoods::where('id','=',$id)->first();

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
}
