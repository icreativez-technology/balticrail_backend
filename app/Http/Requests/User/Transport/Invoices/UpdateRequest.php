<?php

namespace App\Http\Requests\User\Transport\Invoices;


use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function failedValidation(Validator $validator)
    {
         //write your business logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json(["message" => $validator->errors()], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_partner_id' => 'required|integer',
            'payer_partner_id' => 'required|integer',
            'price_list_type_id' => 'required|integer',
            'file_type_id' => 'required|integer',
            'file_path' => 'required|string'  
        ];
    }
}