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
        
    ];

    public $timestamps = false;

    public function materials(){
        return $this->belongsToMany(Material::class)->withPivot('amount');
    }

    public function toppings(){
        return $this->hasMany(Topping::class);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class)->withPivot('active');
    }
}
