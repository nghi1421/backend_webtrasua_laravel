<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function staffs(){
        return $this->hasMany(Staff::class);
    }

    public function routes(){
        return $this->belongsToMany(Route::class);
    }
}
