<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;
    protected $table = 'toppings';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'price',
        'active',
        'drink_id'
    ]; 

    public $timestamps = false;

    public function drink(){
        return $this->belongsTo(Drink::class);
    }

}
