<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
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
        if($method == 'PUT'){
            return [
                'name' => [
                    'required',
                ],
                'uom' => ['required']
            ];
        }
        else{
            return [
                'name' => [
                    'sometimes',
                    'required'
                    
                ],
                'uom' => ['sometimes','required']
            ];
        }
    }
}
