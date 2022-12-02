<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staffs';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'gender',
        'phone_number',
        "address",
        'dob',
        'hometown',
        'active',
        'branch_id',
        'position_id',
        'id_login',
    ];

    public $timestamps = false;

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function importVouchers(){
        return $this->hasMany(ImportVoucher::class);
    }

    public function supplyVouchers(){
        return $this->hasMany(SupplyVoucher::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
