<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menggunakan fungsi DB::table untuk memasukkan data ke dalam tabel products
        DB::table('products')->insert([
            'name' => 'Product 1',
            'price' => 100,
            'stock' => 50,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 2',
            'price' => 150,
            'stock' => 30,
        ]);

        // Tambahkan data lainnya sesuai kebutuhan
    }
}