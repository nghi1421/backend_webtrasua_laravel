<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\TypeOfDrink;

class DrinkResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'discount' => $this->discount,
            'salesOnDay' => $this->sales_on_day,
            'imageSource' => $this->image,
            'active' => $this->active,
            'typeOfDrink' => TypeOfDrink::find($this->tod_id),
        ];
    }
}
