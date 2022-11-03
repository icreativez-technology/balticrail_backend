<?php

namespace App\Http\Controllers\Api\V1\Auth\Railway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Auth\Login\StoreRequest;


use App\Models\Railway\User;

class LoginController extends Controller
{
    public function login(StoreRequest $request)
    {
        $attr = $request->all();

        if (!Auth::guard('railway')->attempt($attr)) {

            $response = [
                'message' => 'Credentials not match'
            ];

            return response($response, Response::HTTP_UNAUTHORIZED);
        }

        $response = [
            'user'  => auth()->guard('railway')->user(),
            'token' => Auth::guard('railway')->user()->createToken('user_access')->accessToken
        ];

        return response($response, Response::HTTP_OK);
    }

    public function update_password(Request $request)
    {
        User::where('id','=',Auth::guard('railway')->id())->update(['password' => bcrypt($request->password),'sync_password' => 1]);
        
        $response = [
            'message' => 'Password Updated'
        ];

        return response($response, Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->guard('railway')->user()->tokens->each(function ($token,$key) {
            $token->delete();
        });

        $response = [
            'message' => 'Successfully logged out'
        ];

        return response($response, Response::HTTP_OK);
    }
}