<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\OrdersFiles;

#Request 
use App\Http\Requests\User\Transport\OrdersFiles\StoreRequest;
use App\Http\Requests\User\Transport\OrdersFiles\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;


class OrdersFilesController extends Controller
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
        $data = OrdersFiles::with('document_type')->where('order_id','=',$id)->get();
        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function store(StoreRequest $request)
    {
        try 
        {
            $file = $request->file('file');
            $file_name = rand(0,20).date('ymdhis');
            $uploaded_file = $this->file_upload($file,$file_name,"doc/");
    
            $data = $request->all();
    
            $record = new OrdersFiles();
            $record->order_id = $data['id'];
            $record->document_type_id = $data['document_type'];
            $record->file_path = $uploaded_file['saveto'];
            $record->file_name = $uploaded_file['filename'];
            $record->complete_path = asset($uploaded_file['saveto'].$uploaded_file['filename']);
            $record->save();
    
            $response = $record;
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


    public function destroy($id)
    {
        $record = OrdersFiles::where('id','=',$id)->first();

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
