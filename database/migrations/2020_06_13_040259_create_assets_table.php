<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipe_id')->references('id')->on('asset_types');
            $table->foreignId('kota_id')->references('id')->on('cities');
            $table->foreignId('pembuat_id')->references('id')->on('users');
            $table->string('judul');
            $table->longText('deskripsi');
            $table->longText('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
