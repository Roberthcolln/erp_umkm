<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_kategori_produk');
            $table->string('nama_produk', 255);
            $table->integer('stok')->default(0);
            $table->string('foto_produk', 255)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_kategori_produk')->references('id_kategori_produk')->on('kategori_produk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
}

