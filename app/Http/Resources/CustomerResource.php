<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AddressCollection;
use App\Models\Address;
class CustomerResource extends JsonResource
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
            'id'  => $this->id,
            'name'  => $this->name,
            'gender'  => $this->gender,
            'phoneNumber'  => $this->phone_number,
            'dob'  => $this->dob,
            'addresses' => new AddressCollection(Address::where('customer_id', $this->id)->get()) == '[]' ? '[]' : new AddressCollection(Address::where('customer_id', $this->id)->get()),
            'active'  => $this->active,
        ];
    }
}
