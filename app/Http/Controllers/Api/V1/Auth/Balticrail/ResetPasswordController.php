<?php

namespace App\Http\Controllers\Api\V1\Auth\Balticrail;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Transformers\Json;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function index(Request $request)
    {
       $this->validate($request, $this->rules(), $this->validationErrorMessages());
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // return $response == Password::PASSWORD_RESET
        // ? $this->sendResetResponse($request,$response)
        // : $this->sendResetFailedResponse($request, $response);

        return $response == Password::PASSWORD_RESET
            ? response()->json($this->sendResetResponse($request,$response), 201)
            : response()->json($this->sendResetFailedResponse($request, $response), 401);


    }
}