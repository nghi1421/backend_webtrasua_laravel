<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                    Rule::unique('materials', 'name')->ignore($this->material),
                    'required',
                ],
                'uom' => ['required']
            ];
        }
        else{
            return [
                'name' => [
                    Rule::unique('materials', 'name')->ignore($this->material),
                    'sometimes',
                    'required'
                    
                ],
                'uom' => ['sometimes','required']
            ];
        }
    }
}
