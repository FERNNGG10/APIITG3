<?php

namespace Database\Seeders;

use App\Models\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sensors = [
            [
                'name'  => "Temperatura",
                'status'    => true
            ],
            [
                'name'  => "Humedad",
                'status'    => true
            ],
            [
                'name'  => "Lluvia",
                'status'    => true
            ],
            [
                'name'  => "Suelo",
                'status'    => true
            ],
            [
                'name'  => "Agua",
                'status'    => true
            ],
            [
                'name'  => "Luz",
                'status'    => true
            ],
            [
                'name'  => "Movimiento",
                'status'    => true
            ],
            [
                'name'  => "Vibracion",
                'status'    => true
            ]
        ];

        foreach ($sensors as $sensor) {
            Sensor::create($sensor);
        }
    }
}
