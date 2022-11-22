<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function staffs(){
        return $this->hasMany(Staff::class);
    }
}
