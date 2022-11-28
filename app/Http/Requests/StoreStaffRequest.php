<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            'gender' => ['required'],
            'phone_number' => ['required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9','unique:staffs,phone_number'],
            'address' => ['required'],
            'hometown' => ['required'],
            'branch_id' => ['required'],
            'position_id' => ['required'],
            'dob' => ['date'],
            'position_id' => ['required'],
            'email' => ['required','email','unique:staffs,email'],
            'active' => ['required','boolean'],
        ];

    }
}
