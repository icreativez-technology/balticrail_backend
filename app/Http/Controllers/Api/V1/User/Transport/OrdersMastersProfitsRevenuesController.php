<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\OrdersMastersProfitsRevenues;


#Request 
use App\Http\Requests\User\Transport\OrdersMastersProfitsRevenues\StoreRequest;
use App\Http\Requests\User\Transport\OrdersMastersProfitsRevenues\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;


class OrdersMastersProfitsRevenuesController extends Controller
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
        $data = OrdersMastersProfitsRevenues::where('order_id','=',$id)->get();
        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $value = $request->all();

            $record = new OrdersMastersProfitsRevenues();
            $record->order_id = isset($value['order_id']) ? $value['order_id'] : 0;
            $record->revenue_code_id = isset($value['revenue_code_id']) ? $value['revenue_code_id'] : 0;
            $record->price = isset($value['price']) ? $value['price'] : 0;
            $record->quantity = isset($value['quantity']) ? $value['quantity'] : 0;
            $record->sum = isset($value['sum']) ? $value['sum'] : 0;
            $record->currency_id = isset($value['currency_id']) ? $value['currency_id'] : 0;
            $record->description = isset($value['description']) ? $value['description'] : 0;
            $record->date = (isset($value['date']) && !empty($value['date'])) ? $value['date'] : null;
            $record->carrier_partner_id = isset($value['carrier_partner_id']) ? $value['carrier_partner_id'] : 0;
            $record->vehicle_id = isset($value['vehicle_id']) ? $value['vehicle_id'] : 0;
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



    public function update(UpdateRequest $request,$id)
    {
        try 
        {
            $value = $request->all();

            $record = OrdersMastersProfitsRevenues::find($id);

            if(isset($record->id))
            {
                $record->revenue_code_id = isset($value['revenue_code_id']) ? $value['revenue_code_id'] : 0;
                $record->price = isset($value['price']) ? $value['price'] : 0;
                $record->quantity = isset($value['quantity']) ? $value['quantity'] : 0;
                $record->sum = isset($value['sum']) ? $value['sum'] : 0;
                $record->currency_id = isset($value['currency_id']) ? $value['currency_id'] : 0;
                $record->description = isset($value['description']) ? $value['description'] : 0;
                $record->date = (isset($value['date']) && !empty($value['date'])) ? $value['date'] : null;
                $record->carrier_partner_id = isset($value['carrier_partner_id']) ? $value['carrier_partner_id'] : 0;
                $record->vehicle_id = isset($value['vehicle_id']) ? $value['vehicle_id'] : 0;
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
        $record = OrdersMastersProfitsRevenues::where('id','=',$id)->first();

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
