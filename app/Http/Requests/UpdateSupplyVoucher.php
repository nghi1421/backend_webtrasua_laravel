<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplyVoucher extends FormRequest
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
        else{
            return[
                'created_at' => ['sometimes'],
                'status' => ['sometimes'],
                'warehouse_id' => ['sometimes'],
                'staff_id' => ['sometimes'],
                'branch_id' => ['sometimes','required'],
                'supply_details' => ['sometimes','required','array'],
                'supply_details.*.material_id' => ['sometimes',''],
                'supply_details.*.amount' => ['sometimes','numeric'],
            ];   
        }
    }
}
