<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'sizes';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
        'ratio',
    ];

    public $timestamps = false;

    public function drinks(){
        return $this->belongsToMany(Drink::class, 'drink_details', 'size_id', 'drink_id');
    }
}
