<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImportVoucher;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouses';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'date_opened',
        'active',
    ];

    public $timestamps = false;

    public function importVouchers(){
        return $this->hasMany(ImportVoucher::class);
    }
}
