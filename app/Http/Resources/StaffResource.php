<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BranchForStaffResource;
use App\Models\Branch;
use App\Http\Resources\PositionResource;
use App\Models\Position;

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
            'branch' => new BranchForStaffResource(Branch::where('id',$this->branch_id)->first()),
            'position' => new PositionResource(Position::where('id',$this->position_id)->first()),
            'active' => $this->active,
        ];
    }
}
