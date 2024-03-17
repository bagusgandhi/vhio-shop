<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Rose Bouquet Glamorous',
                'image' => 'https://asset-3.tstatic.net/jualbeli/img/2023/9/2725908/3-1364044587-Buket-Snack-Wisuda-Jogja.jpg',
                'price' => 200000,
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque esse ea numquam, aut odio magnam illum consectetur ut iste mollitia excepturi, voluptas minima minus quaerat, expedita dignissimos nihil itaque? Rerum?',
                'slug' => 'rose-bouquet-glamorous',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rose Cream Bouquet',
                'image' => 'https://images.tokopedia.net/img/cache/700/VqbcmM/2023/10/13/98eb8809-01a1-4281-953f-b4e11f2c3d53.jpg',
                'price' => 225000,
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque esse ea numquam, aut odio magnam illum consectetur ut iste mollitia excepturi, voluptas minima minus quaerat, expedita dignissimos nihil itaque? Rerum?',
                'slug' => 'rose-cream-bouquet',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snack Bouquet',
                'image' => 'https://images.tokopedia.net/img/cache/700/VqbcmM/2021/2/4/7ffeb95a-7be7-472b-b3ac-b16fb0b45c88.jpg',
                'price' => 175000,
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque esse ea numquam, aut odio magnam illum consectetur ut iste mollitia excepturi, voluptas minima minus quaerat, expedita dignissimos nihil itaque? Rerum?',
                'slug' => 'snack-bouquet',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
