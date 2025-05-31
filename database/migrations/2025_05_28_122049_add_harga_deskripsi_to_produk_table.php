<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('produk', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->integer('harga_produk')->nullable()->after('foto_produk');
        $table->text('deskripsi_produk')->nullable()->after('harga_produk');
        $table->integer('harga_jual')->nullable()->after('deskripsi_produk');
    });
}

public function down()
{
    Schema::table('produk', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn(['harga_produk', 'deskripsi_produk', 'harga_jual']);
    });
}

};
