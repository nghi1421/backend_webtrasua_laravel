<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    protected $table = 'drinks';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sales_on_day',
        'image',
        'active',
        'tod_id'
    ];

    public $timestamps = false;

    public function materials(){
        return $this->belongsToMany(Material::class, 'recipes', 'drink_id', 'material_id')->withPivot('amount');
    }

    public function toppings(){
        return $this->hasMany(Topping::class);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class, 'drink_details', 'drink_id', 'size_id')->withPivot(['id','active']);
    }

    public function typeOfDrink(){
        return $this->belongsTo(TypeOfDrink::class,'tod_id','id');
    }



}
