<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
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
                'gender' => ['required'],
                'phone_number' => ['required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9', Rule::unique('staffs', 'phone_number')->ignore($this->staff)],
                'address' => ['required'],
                'hometown' => ['required'],
                'branch_id' => ['required'],
                'position_id' => ['required'],
                'dob' => ['date'],
                'active' => ['required','boolean'],
           ];
        }
        else{
            return [
                'name' => ['sometimes', 'required'],
                'gender' => ['sometimes', 'required'],
                'phone_number' => ['sometimes', 'required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9', Rule::unique('staffs', 'phone_number')->ignore($this->staff)],
                'address' => ['sometimes', 'required'],
                'hometown' => ['sometimes', 'required'],
                'branch_id' => ['sometimes', 'required'],
                'position_id' => ['sometimes', 'required'],
                'dob' => ['sometimes', 'date'],
                'active' => ['sometimes', 'required','boolean'],
           ];

        }

    }

    // protected function prepareForValidation() {
    //     $this->merge([

    //     ])
    // }
}
