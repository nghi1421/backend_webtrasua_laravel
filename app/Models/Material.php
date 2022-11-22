<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'uom',
    ];

    public $timestamps = false;

    public function branches(){
        return $this->belongsToMany(Branches::class);
    }

    public function warehouses(){
        return $this->belongsToMany(Warehouse::class);
    }

    public function drinks(){
        return $this->belongsToMany(Drinks::class);
    }

    public function importVourchers(){
        return $this->belongsToMany(ImportVoucher::class);
    }

    public function supplyVourchers(){
        return $this->belongsToMany(SupplyVoucher::class);
    }
}
