<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Balticrail\User;


class UsersController extends Controller
{
    public function index()
    {
        $data = User::paginate(50);

        if($data->total() > 0)
        {
            $response = $data;
            $status = Response::HTTP_OK;
        }
        else
        {
            $response = [
                'message' => 'No Records Found'
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response($response, $status);
    }

    public function lookup(Request $request)
    {
        $records = User::get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }


}
