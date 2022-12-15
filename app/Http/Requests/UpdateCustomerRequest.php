<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        $method = $this->method();
        if($method == "PUT"){
            return [
                'name' => ['required'],
                'phone_number' => [
                    'required',
                    'regex:/(0)[0-9]/','not_regex:/[a-z]/',
                    'min:9',
                    Rule::unique('customers', 'phone_number')->ignore($this->customer)
                ],
                'dob' => ['date'],
            ];
        }
        else{
            return [
                'name' => ['sometimes','required'],
                'phone_number' => [
                    'sometimes',
                    'required',
                    'regex:/(0)[0-9]/',
                    'not_regex:/[a-z]/',
                    'min:9',
                    // 'unique:customers,
                    // phone_number,' . $this->phone_number
                ],
                'dob' => ['date'],
            ];

        }
    }
}
