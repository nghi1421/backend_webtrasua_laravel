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
        // return $this->belongsToMany(Branch::class, 'branch_materials');
        return $this->belongsToMany(Branch::class, 'branch_materials',  'material_id','branch_id')->withPivot('amount');
    }

    public function warehouses(){
        return $this->belongsToMany(Warehouse::class)->withPivot('amount');
    }

    public function drinks(){
        return $this->belongsToMany(Drink::class)->withPivot('amount');
    }

    public function importVourchers(){
        return $this->belongsToMany(ImportVoucher::class)->withPivot('amount');
    }

    public function supplyVourchers(){
        return $this->belongsToMany(SupplyVoucher::class)->withPivot('amount');
    }
}
