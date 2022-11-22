<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $primaryKey   = ['route_id', 'role_id'];

    protected $fillable = [
        'status',
    ];

    public $timestamps = false;

}
