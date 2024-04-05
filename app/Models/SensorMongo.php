<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class SensorMongo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'sensores';
    protected $fillable = [
        
        'Temperatura', 'Humedad', 'Lluvia', 'Suelo', 'Agua', 'Luz', 'Movimiento', 'Vibracion'
    
    ];
    use HasFactory;
}
