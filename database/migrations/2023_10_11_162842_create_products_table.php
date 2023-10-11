<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Kolom id dengan tipe data integer dan otomatis bertambah
            $table->string('name'); // Kolom name dengan tipe data string
            $table->integer('price'); // Kolom price dengan tipe data integer
            $table->integer('stock'); // Kolom stock dengan tipe data integer
            $table->timestamps(); // Kolom created_at dan updated_at untuk menyimpan waktu pembuatan dan pembaruan record
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

