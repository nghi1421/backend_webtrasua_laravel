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
                'phone_number' => ['required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9','unique:staffs,phone_number,'.$this->phone_number],
                'address' => ['required'],
                'hometown' => ['required'],
                'branch_id' => ['required'],
                'position_id' => ['required'],
                'email' => ['required','email','unique:staffs,email'],
           ];
        }
        else{
            return [
                'name' => ['sometimes','required'],
                'gender' => ['sometimes','required'],
                'phone_number' => ['sometimes','required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9','unique:staffs,phone_number,'.$this->phone_number],
                'address' => ['sometimes','required'],
                'hometown' => ['sometimes','required'],
                'branch_id' => ['sometimes','required'],
                'position_id' => ['sometimes','required'],
                'email' => ['sometimes','required','email','unique:staffs,email'],
           ];

        }

    }

    // protected function prepareForValidation() {
    //     $this->merge([

    //     ])
    // }
}
