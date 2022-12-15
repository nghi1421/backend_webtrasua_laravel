<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSize extends FormRequest
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
        if( $method  == 'PUT'){
            return [
                'name' => [
                    'required',
                    Rule::unique('sizes', 'name')->ignore($this->size)
                ],
                'ratio' => ['required','numeric']
            ];
        }
        else{
            return [
                'name' => [
                    'sometimes','required',
                    Rule::unique('sizes', 'name')->ignore($this->size)
                ],
                'ratio' => ['sometimes','required','numeric']
            ];
        }
    }
}
