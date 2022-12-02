<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public $timestamps = false;

    public function role(){
        return $this->belongsTo(Role::class);
    }

}
