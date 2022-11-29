<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkDetail extends Model
{
    use HasFactory;
    protected $table = 'drink_details';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'active',
        'drink_id',
        'size_id',
    ];

    public $timestamps = false;

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_details', 'drink_detail_id', 'order_id')->withPivot(['quantity', 'topping_list']);
    }

    public function toppings(){
        return $this->hasMany(Topping::class);
    }

}
