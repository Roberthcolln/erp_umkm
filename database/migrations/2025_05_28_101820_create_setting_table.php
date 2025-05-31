<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id('id_setting');
            $table->string('instansi_setting')->nullable();
            $table->string('pimpinan_setting')->nullable();
            $table->string('logo_setting')->nullable();
            $table->string('favicon_setting')->nullable();
            $table->text('tentang_setting')->nullable();
            $table->string('keyword_setting')->nullable();
            $table->text('alamat_setting')->nullable();
            $table->string('instagram_setting')->nullable();
            $table->string('youtube_setting')->nullable();
            $table->string('email_setting')->nullable();
            $table->string('no_hp_setting')->nullable();
            $table->text('maps_setting')->nullable();
            $table->string('background_setting')->nullable();
            $table->string('bg_tentang_setting')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
