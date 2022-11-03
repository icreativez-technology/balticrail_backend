<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\Partners;
use App\Models\Transport\Countries;

#Request 
use App\Http\Requests\User\Transport\Partners\StoreRequest;
use App\Http\Requests\User\Transport\Partners\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class PartnersController extends Controller
{
    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public $pagination;

    public function __construct()
    {
        $this->pagination = $this->pagination_count();
    }

    public function index()
    {
        $data = Partners::with('partner_representative')->with('country')->paginate($this->pagination);
        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $data = $request->all();

            if(isset($data['country_iso']))
            {
                $country_info = Countries::where('iso','=',$data['country_iso'])->first();

                if(isset($country_info->id))
                {
                    $data['country_id'] = $country_info->id;   
                }
            }

            $record = new Partners();
            $record->code = isset($data['code']) ? $data['code'] : Null;
            $record->company_name = isset($data['company_name']) ? $data['company_name'] : Null;
            $record->address = isset($data['address']) ? $data['address'] : Null;
            $record->postal_code = isset($data['postal_code']) ? $data['postal_code'] : Null;
            $record->city = isset($data['city']) ? $data['city'] : Null;
            $record->country_id = isset($data['country_id']) ? $data['country_id'] : Null;
            $record->latitude = isset($data['latitude']) ? $data['latitude'] : Null;
            $record->longitude = isset($data['longitude']) ? $data['longitude'] : Null;
            $record->phone = isset($data['phone']) ? $data['phone'] : Null;
            $record->email = isset($data['email']) ? $data['email'] : Null;
            $record->website = isset($data['website']) ? $data['website'] : Null;
            $record->registration_number = isset($data['registration_number']) ? $data['registration_number'] : Null;
            $record->vat_number = isset($data['vat_number']) ? $data['vat_number'] : Null;
            $record->bank_account_number = isset($data['bank_account_number']) ? $data['bank_account_number'] : Null;
            $record->pack_code = isset($data['pack_code']) ? $data['pack_code'] : Null;
            $record->language = isset($data['language']) ? $data['language'] : Null;
            $record->payment_terms = isset($data['payment_terms']) ? $data['payment_terms'] : Null;
            $record->vat = isset($data['vat']) ? $data['vat'] : Null;
            $record->interest = isset($data['interest']) ? $data['interest'] : Null;
            $record->client_address = isset($data['client_address']) ? $data['client_address'] : Null;
            $record->currency = isset($data['currency']) ? $data['currency'] : Null;
            $record->credit_limit = isset($data['credit_limit']) ? $data['credit_limit'] : Null;
            $record->discount = isset($data['discount']) ? $data['discount'] : Null;
            $record->partner_type = isset($data['partner_type']) ? $data['partner_type'] : Null;
            $record->sync_id = isset($data['sync_id']) ? $data['sync_id'] : 0;
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
            $record = Partners::find($id);
 
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

            $record = Partners::find($id);

            if(isset($record->id))
            {            
                if(isset($data['country_iso']))
                {
                    $country_info = Countries::where('iso','=',$data['country_iso'])->first();
    
                    if(isset($country_info->id))
                    {
                        $data['country_id'] = $country_info->id;   
                    }
                }

                $record->code = isset($data['code']) ? $data['code'] : Null;
                $record->company_name = isset($data['company_name']) ? $data['company_name'] : Null;
                $record->address = isset($data['address']) ? $data['address'] : Null;
                $record->postal_code = isset($data['postal_code']) ? $data['postal_code'] : Null;
                $record->city = isset($data['city']) ? $data['city'] : Null;
                $record->country_id = isset($data['country_id']) ? $data['country_id'] : Null;
                $record->latitude = isset($data['latitude']) ? $data['latitude'] : Null;
                $record->longitude = isset($data['longitude']) ? $data['longitude'] : Null;
                $record->phone = isset($data['phone']) ? $data['phone'] : Null;
                $record->email = isset($data['email']) ? $data['email'] : Null;
                $record->website = isset($data['website']) ? $data['website'] : Null;
                $record->registration_number = isset($data['registration_number']) ? $data['registration_number'] : Null;
                $record->vat_number = isset($data['vat_number']) ? $data['vat_number'] : Null;
                $record->bank_account_number = isset($data['bank_account_number']) ? $data['bank_account_number'] : Null;
                $record->pack_code = isset($data['pack_code']) ? $data['pack_code'] : Null;
                $record->language = isset($data['language']) ? $data['language'] : Null;
                $record->payment_terms = isset($data['payment_terms']) ? $data['payment_terms'] : Null;
                $record->vat = isset($data['vat']) ? $data['vat'] : Null;
                $record->interest = isset($data['interest']) ? $data['interest'] : Null;
                $record->client_address = isset($data['client_address']) ? $data['client_address'] : Null;
                $record->currency = isset($data['currency']) ? $data['currency'] : Null;
                $record->credit_limit = isset($data['credit_limit']) ? $data['credit_limit'] : Null;
                $record->discount = isset($data['discount']) ? $data['discount'] : Null;
//                $record->partner_type = isset($data['partner_type']) ? $data['partner_type'] : Null;
                $record->partner_type = 1;

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
        $record = Partners::where('id','=',$id)->first();

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
        if($request->type == "all")
        {
            $data = Partners::get();
        }
        else 
        {
            $data = Partners::where('partner_type','=',$request->type)->get();
        }

        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }
}    
