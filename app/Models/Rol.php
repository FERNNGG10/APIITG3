<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table ='roles';
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'rol'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
