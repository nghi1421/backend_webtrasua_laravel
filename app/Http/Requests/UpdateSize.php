<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                    'unique:sizes,name,'.$this->name
                ],
                'ratio' => ['required','numeric']
            ];
        }
        else{
            return [
                'name' => [
                    'sometimes','required',
                    'unique:sizes,name,'.$this->name
                ],
                'ratio' => ['sometimes','required','numeric']
            ];
        }
    }
}
