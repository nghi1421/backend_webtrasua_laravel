<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'created_at',
        'paid',
        'note',
        'status',
    ];

    public $timestamps = false;

    public function branch(){
        return $this->hasOne(Branch::class);
    }

    public function staff(){
        return $this->hasOne(Staff::class);
    }

    public function shipping(){
        return $this->hasOne(ShippingProvider::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function drinkDetails(){
        return $this->belongsToMany(DrinkDetail::class);
    }
}
