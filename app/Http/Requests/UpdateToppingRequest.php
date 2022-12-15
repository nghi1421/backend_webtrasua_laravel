<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateToppingRequest extends FormRequest
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
                'price' => ['required', 'numeric'],
                'active' => ['required', 'boolean'],
            ];
        }else{
            return [
                'price' => ['sometimes','required', 'numeric'],
                'active' => ['sometimes','required', 'boolean'],
            ];
        }
    }
}
