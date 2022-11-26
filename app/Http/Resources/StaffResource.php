<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phoneNumber' => $this->phone_number,
            'gender' => $this->gender,
            'address' => $this->address,
            'hometown' => $this->hometown,
            'dob' => $this->dob,
            'email' => $this->email,
            'branchId' => $this->branch_id,
            'positionId' => $this->position_id,
            'active' => $this->active,
        ];
    }
}
