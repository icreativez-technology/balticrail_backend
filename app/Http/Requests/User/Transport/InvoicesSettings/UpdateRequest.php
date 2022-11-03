<?php

namespace App\Http\Requests\User\Transport\InvoicesSettings;


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
        //    'invoice_id' => ['required', Rule::unique('invoices_settings')->ignore($this->invoice_id,'invoice_id')]
        'profit_center' => 'string',
        'currency_id' => 'integer',
        'invoice_date' => 'date',
        'due_date' => 'date',
        'payment_terms' => 'string',
        'accounting_date' => 'date',
        'is_prepayment_invoice' => 'integer'
        ];
    }
}