<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDrinkRequest extends FormRequest
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
        return [
            'name' => ['required', 'unique:drinks,name'],
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
            'topping.*.name' => ['string'],
            'topping.*.price' => ['numeric'],
            'topping.*.active' => ['boolean'],

            'size' => ['array'],
            'size.*.id' => ['integer'],
            'size.*.active' => ['boolean'],
        ];
    }
}
