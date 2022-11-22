<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfDrink extends Model
{
    use HasFactory;
    protected $table = 'type_of_drinks';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'name',
    ]; 

    public $timestamps = false;

    public function drinks(){
        return $this->hasMany(Drink::class);
    }
}
