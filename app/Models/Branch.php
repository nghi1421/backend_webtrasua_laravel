<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'date_opened',
        'active',
    ];

    public $timestamps = false;

    public function materials(){
        return $this->belongsToMany(Material::class, 'branch_materials','branch_id', 'material_id' )->withPivot('amount');
    }

    public function getBranchMaterial($branch_id){
        return $this->materials()->find($brand_id);
    }

    public function staffs(){
        return $this->hasMany(Staff::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
