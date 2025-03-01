<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shops')->insert([
            [ 'owner_id'=>1,
            'name'=>'ここに店名が入ります',
            'information'=> 'ここにお店の情報がはいります',
            'filename'=> 'sample.jpg.png',
            'is_selling'=>true,
            ],
            
            [ 'owner_id'=>2,
            'name'=>'ここに店名が入ります',
            'information'=> 'ここにお店の情報がはいります',
            'filename'=> 'sample2.jpg.png',
            'is_selling'=>true,
            ],
            
        ]);

    }
}
