<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportVoucher extends Model
{
    use HasFactory;
    protected $table = 'import_vouchers';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'created_at',
        'status',
        'staff_id',
        'warehouse_id',
        'provider_id',
    ];

    public $timestamps = false;

    public function staff(){
        return $this->belongsTo(Staff::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function materials(){
        return $this->belongsToMany(Material::class, 'import_details', 'imp_vou_id', 'material_id')->withPivot('amount');
    }
    
}
