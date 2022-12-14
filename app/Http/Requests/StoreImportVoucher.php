<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImportVoucher extends FormRequest
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
            'provider_id' => ['required'],
            'import_details' => ['required','array'],
            'import_details.*.material_id' => [''],
            'import_details.*.amount' => ['numeric'],
        ];
    }
}
