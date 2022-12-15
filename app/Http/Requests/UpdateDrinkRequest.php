<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDrinkRequest extends FormRequest
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
                'name' => ['required', Rule::unique('drinks', 'name')->ignore($this->drink)],
                'slug' => ['string'],
                'description' => ['string'],
                'price' => [
                        'required',
                        'numeric'
                    ],
                'discount' => ['required', 'numeric'],
                'image' => ['required', 'url'],
                'active' => ['required', 'boolean'],
                'tod_id' => ['required', 'exists:type_of_drinks,id'],
                'active' => ['required'],
                'recipe' => ['required','array', 'min:1'],
                'recipe.*.id' => ['required','integer'],
                'recipe.*.amount' => ['required'],

                'topping' => ['array'],
                'topping.*.id' => [],
                'topping.*.name' => ['string'],
                'topping.*.price' => ['numeric'],
                'topping.*.active' => ['boolean'],

                'size' => ['array'],
                'size.*.id' => ['integer'],
                'size.*.active' => ['boolean'],
            ]; 
        }
        else{
            return [
                'name' => ['sometimes','required'],
                'slug' => ['string'],
                'description' => ['string'],
                'price' => [
                        'sometimes','required',
                        'numeric'
                    ],
                'discount' => ['sometimes','required', 'numeric'],
                'image' => ['sometimes','required', 'url'],
                'active' => ['sometimes','required', 'boolean'],
                'tod_id' => ['sometimes','required', 'exists:type_of_drinks,id'],
                'active' => ['sometimes','required'],
                'recipe' => ['sometimes','required','array', 'min:1'],
                'recipe.*.id' => ['sometimes','required','integer'],
                'recipe.*.amount' => ['sometimes','required'],

                'size' => ['array'],
                'size.*.id' => ['integer'],
                'size.*.active' => ['boolean'],
            ]; 
        }

        
    }
}
