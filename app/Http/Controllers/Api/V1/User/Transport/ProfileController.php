<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#Model
use App\Models\Transport\User;


class ProfileController extends Controller
{
    public function show()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        return response($user, Response::HTTP_OK);
    }
}
