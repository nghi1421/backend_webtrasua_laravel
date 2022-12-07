<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Branch;
use App\Models\Position;
class StaffAuthResource extends JsonResource
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
            // 'branch' => new BranchResource(Branch::where('id',$this->branch_id)->first()),
            'branch' => Branch::select('id', 'name')
                        ->where('id', $this->branch_id)
                        ->first(),
            'position' => Position::find($this->position_id),
            'active' => $this->active,
    ];
    }
}
