<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImportVoucher extends FormRequest
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
            'provider_id' => ['required'],
            'import_details' => ['required','array'],
            'import_details.*.material_id' => [''],
            'import_details.*.amount' => ['numeric'],
            ];
            
        }
        else{
            return[
                'created_at' => ['sometimes'],
                'status' => ['sometimes'],
                'warehouse_id' => ['sometimes'],
                'staff_id' => ['sometimes'],
                'provider_id' => ['sometimes','required'],
                'import_details' => ['sometimes','required','array'],
                'import_details.*.material_id' => ['sometimes',''],
                'import_details.*.amount' => ['sometimes','numeric'],
            ];   
        }
    }
}
