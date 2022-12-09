<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyVoucher extends Model
{
    use HasFactory;
    protected $table = 'supply_vouchers';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'created_at',
        'status',
        'staff_id',
        'warehouse_id',
    ]; 

    public $timestamps = false;

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function materials(){
        return $this->belongsToMany(Material::class, 'supply_details', 'sup_vou_id', 'material_id')->withPivot('amount');;
    }

}
