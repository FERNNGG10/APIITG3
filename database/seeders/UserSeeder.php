<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'  => "Fernando",
                'email' => "fgolmos10@gmail.com",
                'rol_id'    =>  2,
                'status'    => true,
                'password'  => Hash::make('12345678'),
                'code'  => Crypt::encrypt(rand(100000,999999))
            ],
            [
                'name'  => "Adrian",
                'email' => "jorge.liralopez11.com",
                'rol_id'    =>  2,
                'status'    => true,
                'password'  => Hash::make('12345678'),
                'code'  => Crypt::encrypt(rand(100000,999999))
            ],
            [
                'name'  => "Vielma",
                'email' => "vielma7220@gmail.com",
                'rol_id'    =>  2,
                'status'    => true,
                'password'  => Hash::make('12345678'),
                'code'  => Crypt::encrypt(rand(100000,999999))
            ],
            [
                'name'  => "Arturo",
                'email' => "hernandez020610@gmail.com",
                'rol_id'    =>  2,
                'status'    => true,
                'password'  => Hash::make('12345678'),
                'code'  => Crypt::encrypt(rand(100000,999999))
            ],
            [
                'name'  => "Jorge",
                'email' => "jorgefullscout2.0@gmail.com",
                'rol_id'    =>  2,
                'status'    => true,
                'password'  => Hash::make('password'),
                'code'  => Crypt::encrypt(rand(100000,999999))
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
