<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        if( $method == "PUT"){
            return [
                'email' => ['required','email',Rule::unique('users', 'email')->ignore($this->user)],
                'password' => [
                    'required',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ],
                'role_id' => 'required',
                'staff_id' => ['required', 'exists:staffs,id']
            ];
        }
        else{
            return [
                'email' => ['sometimes','required','email',Rule::unique('users', 'email')->ignore($this->user)],
                'password' => [
                    'sometimes','required',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ],
                'role_id' => 'sometimes','required',
                'staff_id' => ['sometimes','required', 'exists:staffs,id']
            ];
        }
    }
}
