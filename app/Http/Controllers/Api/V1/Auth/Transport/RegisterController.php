<?php

namespace App\Http\Controllers\Api\V1\Auth\Transport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Transport\User;

use App\Http\Requests\Auth\Register\StoreRequest;

class RegisterController extends Controller
{
    public function register(StoreRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'occupation' => $data['occupation'],
            'phone' => $data['phone'],
            'language' => $data['language'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'sync_id' => $data['sync_id']
        ]);

        Auth::guard('transport')->login($user);

        $response = [
            'user'  => $user,
            'token' => Auth::guard('transport')->user()->createToken('user_access')->accessToken
        ];

        return response($response, Response::HTTP_OK);
    }
}
