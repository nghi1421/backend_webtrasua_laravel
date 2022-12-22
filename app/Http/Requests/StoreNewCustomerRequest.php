<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewCustomerRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'phone_number' => ['required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9','unique:customers,phone_number'],
            'dob' => ['date'],
            'gender' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ];
    }
}
