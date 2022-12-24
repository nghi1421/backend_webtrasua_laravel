<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'paid' =>[ 
                'required','boolean'
            ],
            'note' =>[ 
                // 'string'
            ],
            // 'created_at' =>[ 
            //     'timestamp'
            // ],
            'staff_id' => [
                //  'sometimes','exists:staffs,id'
            ],
            'customer_id' => [
                //  'sometimes','exists:customers,id'
            ],
            'address_id' => [
                //  'sometimes','exists:addresses,id'
            ],
            'branch_id' => [
                //  'sometimes','exists:branches,id'
            ],
            'shipping_id' => [
                //  'sometimes','exists:shipping_providers,id'
            ],
            'order_detail' => [
                // 'required',
                'array',
                'min:1'
            ],
            'order_detail.*.drink_detail_id' => [
                'required',
            ],
            'order_detail.*.quantity' => [
                'required',
                'numeric'
            ],
            'order_detail.*.price' => [
                'required',
            ],
            'order_detail.*.topping_list' => [
                'array',
            ],
            'order_detail.*.topping_list.*.quan' => [
                'required',
                'numeric'
            ]
            ,
            'order_detail.*.topping_list.*.topping' => [
                'required',
                'array',
            ],
            'order_detail.*.topping_list.*.topping.*.topping_id' => [
                // 'required', 'exists:toppings,id'
            ]
        ];
    }
}
