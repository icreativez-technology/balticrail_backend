<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\PartnersTypes;

#Request 
use App\Http\Requests\User\Transport\PartnersTypes\StoreRequest;
use App\Http\Requests\User\Transport\PartnersTypes\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class PartnersTypesController extends Controller
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
        $records = PartnersTypes::paginate($this->pagination);
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $data = $request->all();

            $record = new PartnersTypes();
            $record->name = $data['name'];
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
            $record = PartnersTypes::find($id);
 
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

            $record = PartnersTypes::find($id);

            if(isset($record->id))
            {            
                $record->name = $data['name'];
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
        $record = PartnersTypes::where('id','=',$id)->first();

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
        $records = PartnersTypes::get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

}