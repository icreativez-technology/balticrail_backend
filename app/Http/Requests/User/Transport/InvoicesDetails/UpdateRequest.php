<?php

namespace App\Http\Requests\User\Transport\InvoicesDetails;


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
            'invoice_id' => 'required|integer',
            'expense_revenue_code_id' => 'required|integer',
            'expense_revenue_code_type' => 'required|string',
            'description' => 'required',
            'unit' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'sum' => 'required|numeric',
            'vat' => 'required|numeric'
        ];
    }
}