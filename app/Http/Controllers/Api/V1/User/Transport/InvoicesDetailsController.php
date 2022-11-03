<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\InvoicesDetails;
use Illuminate\Http\Request;

#Request 
use App\Http\Requests\User\Transport\InvoicesDetails\StoreRequest;
use App\Http\Requests\User\Transport\InvoicesDetails\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class InvoicesDetailsController extends Controller
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
        $records = InvoicesDetails::where('invoice_id','=',$id)->get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $data = $request->all();

            $record = new InvoicesDetails();
            $record->invoice_id = $data['invoice_id'];
            $record->invoice_detail_id = isset($data['invoice_detail_id']) ? $data['invoice_detail_id'] : date('ymdhis');
            $record->expense_revenue_code_id = $data['expense_revenue_code_id'];
            $record->expense_revenue_code_type = $data['expense_revenue_code_type'];
            $record->description = $data['description'];
            $record->unit = $data['unit'];
            $record->quantity = $data['quantity'];
            $record->price = $data['price'];
            $record->sum = $data['sum'];
            $record->vat = $data['vat'];
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
            $record = InvoicesDetails::find($id);
 
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

            $record = InvoicesDetails::find($id);

            if(isset($record->id))
            {            
                $record->invoice_id = $data['invoice_id'];
                $record->expense_revenue_code_id = $data['expense_revenue_code_id'];
                $record->expense_revenue_code_type = $data['expense_revenue_code_type'];
                $record->description = $data['description'];
                $record->unit = $data['unit'];
                $record->quantity = $data['quantity'];
                $record->price = $data['price'];
                $record->sum = $data['sum'];
                $record->vat = $data['vat'];
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
        $record = InvoicesDetails::where('id','=',$id)->first();

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