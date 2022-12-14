<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $method = $this->methed();
        if( $method == "PUT"){
            return [
                'email' => ['required,email,string,',Rule::unique('users', 'email')->ignore($this->user)],
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ],
                'role_id' => 'required',
                'staff_id' => 'required'
            ];
        }
        else{
            return [
                'email' => 'sometimes',['required,email,string,',Rule::unique('users', 'email')->ignore($this->user)],
                'password' => [
                    'sometimes','required',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ],
                'role_id' => 'sometimes','required',
                'staff_id' => 'sometimes','required'
            ];
        }
    }
}
