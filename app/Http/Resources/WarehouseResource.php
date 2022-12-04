<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Warehouse;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $warehouse_materials = Warehouse::find($this->id)->materials()->get();
        $index = 0 ;
        $materials = [];
        foreach ($warehouse_materials as $material) {
            $materials[$index] = [
                'id' => $material['id'],
                'name' => $material['name'],
                'uom' => $material['uom'],
                'amount' => $material['pivot']['amount']
            ];
            $index+=1;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phoneNumber' => $this->phone_number,
            'dateOpened' => $this->date_opened,
            'active' => $this->active,
            'materialsOfBranch' => $materials,
        ];
    }
}
