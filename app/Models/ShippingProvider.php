<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingProvider extends Model
{
    use HasFactory;
    protected $table = 'shipping_providers';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function orders(){
        return $this->hasMany(Order::class, 'shipping_id', 'id');
    }
}
