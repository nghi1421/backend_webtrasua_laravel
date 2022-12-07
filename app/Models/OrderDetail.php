<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $primaryKey   = ['drink_detail_id', 'order_id'];

    protected $fillable = [
        'drink_detail_id',
        'order_id',
        'price',
        'quantity',
        'topping_list'
    ];

    public $timestamps = false;


    protected $casts = [
        'topping_list' => 'array'
   ];
}
