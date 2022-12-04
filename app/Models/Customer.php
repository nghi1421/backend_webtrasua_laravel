<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'gender',
        'phone_number',
        'dob',
        'active'
    ];

    public $timestamps = false;

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
