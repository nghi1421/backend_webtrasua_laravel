<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


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

        $size_drink = $this->sizes()->get();
        $sizes = [];
        $index = 0;
        foreach ($size_drink as $size) {
            if($size['pivot']['active']){
                $sizes[$index] = [
                    'id' => $size['pivot']['id'],
                    'name' => $size['name'],
                    'price' => ($size['ratio']-1)*$this['price'],

                ];
                $index +=1;
            }
        }

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
            'typeOfDrink' => $this->typeOfDrink()->get(),
            'toppings' => $this->toppings()->get(),
            'size' => $sizes
        ];
    }
}
