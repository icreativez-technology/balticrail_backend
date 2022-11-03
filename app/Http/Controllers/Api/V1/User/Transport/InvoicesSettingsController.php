<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\InvoicesSettings;

#Request 
use App\Http\Requests\User\Transport\InvoicesSettings\StoreRequest;
use App\Http\Requests\User\Transport\InvoicesSettings\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class InvoicesSettingsController extends Controller
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
        $records = InvoicesSettings::where('invoice_id','=',$id)->get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $data = $request->all();

            $record = InvoicesSettings::where('invoice_id','=',$data['invoice_id'])->first();

            if(!isset($record->id))
            {
                $record = new InvoicesSettings();

                $response = [
                    'message' => __('api.record_added'),
                    'data' => $record
                ];    
            }
            else
            {
                $response = [
                    'message' => __('api.record_updated'),
                    'data' => $record
                ];

            }

            $record->invoice_id = $data['invoice_id'];
            $record->profit_center = $data['profit_center'];
            $record->currency_id = $data['currency_id'];
            $record->invoice_date = $data['invoice_date'];
            $record->due_date = $data['due_date'];
            $record->payment_terms = $data['payment_terms'];
            $record->accounting_date = $data['accounting_date'];
            $record->is_prepayment_invoice = $data['is_prepayment_invoice'];
            $record->save();


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
            $record = InvoicesSettings::find($id);
 
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

            $record = InvoicesSettings::find($id);

            if(isset($record->id))
            {            
                $record->profit_center = $data['profit_center'];
                $record->currency_id = $data['currency_id'];
                $record->invoice_date = $data['invoice_date'];
                $record->due_date = $data['due_date'];
                $record->payment_terms = $data['payment_terms'];
                $record->accounting_date = $data['accounting_date'];
                $record->is_prepayment_invoice = $data['is_prepayment_invoice'];
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
        $record = InvoicesSettings::where('id','=',$id)->first();

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
        $records = InvoicesSettings::get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

}