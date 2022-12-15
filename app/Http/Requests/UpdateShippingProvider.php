<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShippingProvider extends FormRequest
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
                'name' => ['required', Rule::unique('shipping_providers', 'name')->ignore($this->shipping_provider)],
           ];
        }
        else{
            return [
                'name' => ['sometimes', 'required', Rule::unique('shipping_providers', 'name')->ignore($this->shipping_provider)],
           ];
        }
    }
}
