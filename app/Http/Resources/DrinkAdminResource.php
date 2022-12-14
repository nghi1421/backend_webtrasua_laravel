<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DrinkAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $recipe_drink = $this->materials()->get();
        $recipe = [];
        $index = 0;
        foreach ($recipe_drink as $material) {
            $recipe[$index] = [
                'id' => $material['id'],
                'name' => $material['name'],
                'uom' => $material['uom'],
                'amount' => $material['pivot']['amount']
            ];
            $index +=1;
        }

        $size_drink = $this->sizes()->get();
        $sizes = [];
        $index = 0;
        foreach ($size_drink as $size) {
            $sizes[$index] = [
                'id' => $size['pivot']['id'],
                'name' => $size['name'],
                'ratio' => $size['ratio'],
                'active' => $size['pivot']['active'],
            ];
            $index +=1;
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
            'sizes' => $sizes,
            'recipes' => $recipe
        ];
    }
}
