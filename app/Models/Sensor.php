<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table='sensors';
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'status'
    ];

    public function plants(){
        return $this->belongsToMany(Plant::class);
    }
}
