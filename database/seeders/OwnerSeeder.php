<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('owners')->insert([
            [ 'name'=>'test',
            'email'=>'test@test.com',
            'password'=>Hash::make('password123'),
            'created_at'=> now(),
            ],

            [ 'name'=>'test',
            'email'=>'test2@test.com',
            'password'=>Hash::make('password123'),
            'created_at'=> now(),
            ], 
            
            [ 'name'=>'test',
            'email'=>'test3@test.com',
            'password'=>Hash::make('password123'),
            'created_at'=> now(),
            ],

            [ 'name'=>'test',
            'email'=>'test4@test.com',
            'password'=>Hash::make('password123'),
            'created_at'=> now(),
            ],

            [ 'name'=>'test',
            'email'=>'test5@test.com',
            'password'=>Hash::make('password123'),
            'created_at'=> now(),
            ],

            [ 'name'=>'test',
            'email'=>'test6@test.com',
            'password'=>Hash::make('password123'),
            'created_at'=> now(),
            ],
        ]);
    }
}
