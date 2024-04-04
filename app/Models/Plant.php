<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $table='plants';
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'plant',
        'user_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sensors(){
        return $this->belongsToMany(Sensor::class,'plant_sensor');
    }


}
