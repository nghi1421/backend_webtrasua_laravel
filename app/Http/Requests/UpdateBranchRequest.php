<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
                'name' => ['sometimes','required'],
                'address' => ['required'],
                'phone_number' => [
                    'required',
                    'regex:/(0)[0-9]/','not_regex:/[a-z]/',
                    'min:9',
                ],
                'date_opened' => ['date'],
                'active' => ['required'],
                'list_material' => ['required','array', 'min:1'],
                'list_material.*.id' => ['integer'],
                'list_material.*.amount' => ['required'],
            ];
        }
        else{
            return [
                'name' => ['sometimes','required'],
                'address' => ['sometimes','required'],
                'phone_number' => [
                    'sometimes','required',
                    'regex:/(0)[0-9]/','not_regex:/[a-z]/',
                    'min:9',
                ],
                'date_opened' => ['date'],
                'active' => ['sometimes','required'],
                'list_material' => ['sometimes','required','array', 'min:1'],
                'list_material.*.id' => ['integer'],
                'list_material.*.amount' => ['sometimes','required'],
            ];
        }
    }
}
