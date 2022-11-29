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
        return $this->belongsToMany(Warehouse::class, 'warehouse_materials',  'material_id', 'warehouse_id')->withPivot('amount');
    }

    public function drinks(){
        return $this->belongsToMany(Drink::class, 'recipes',  'material_id', 'drink_id')->withPivot('amount');
    }

    public function importVouchers(){
        return $this->belongsToMany(ImportVoucher::class, 'import_details',  'material_id', 'imp_vou_id')->withPivot('amount');
    }

    public function supplyVouchers(){
        return $this->belongsToMany(SupplyVoucher::class, 'supply_details',  'material_id','sup_vou_id')->withPivot('amount');
    }
}
