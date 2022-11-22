<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
