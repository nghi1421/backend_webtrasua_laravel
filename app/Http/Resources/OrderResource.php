<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Staff;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\ShippingProvider;
use App\Http\Resources\StaffResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $status = '';
        // if($this->status == 0 )
        // $status = "Hủy";
        // elseif($this->status == 1)
        // $status = "Đã xác nhận";
        // elseif($this->status == 1)
        // $status = "Đang pha chế";
        // elseif($this->status == 1)
        // $status = "Đã pha chế";
        // elseif($this->status == 1)
        // $status = "Đã trả món";
        
        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'paid' => $this->paid == 0 ? "Chưa thanh toán" :"Đã thanh toán",
            'status' => $this->status,
            'note' => $this->note,
            'staff' => $this->staff_id == null ? 'null' : new StaffResource(Staff::find($this->staff_id)),
            'shippingProvider' => $this->shipping_id == null ? 'null' : ShippingProvider::find($this->shipping_id),
            'address' => $this->address_id == null ? 'null' : Address::find($this->address_id),
            'branch' => Branch::select('id', 'name', 'address')->where('id', '=', $this->branch_id)->first(),
            'customer' => $this->customer_id == null ? 'null' : Customer::select('id', 'name')->where('id', '=', $this->customer_id)->first()
        ];
    }
}
