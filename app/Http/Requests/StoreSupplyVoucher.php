<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplyVoucher extends FormRequest
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
            'created_at' => [],
            'status' => [],
            'warehouse_id' => [],
            'staff_id' => [],
            'branch_id' => ['required'],
            'supply_details' => ['required','array'],
            'supply_details.*.material_id' => [''],
            'supply_details.*.amount' => ['numeric'],
        ];
    }
}
