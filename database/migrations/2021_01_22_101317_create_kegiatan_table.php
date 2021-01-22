<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->string('sasaran_kegiatan');
            $table->string('kegiatan');
            $table->string('satuan_kegiatan');
            $table->string('uraian');
            $table->string('pelaporan');
            $table->integer('durasi');
            $table->string('satuan_waktu');
            $table->integer('jumlah_pertemuan');
            $table->double('ekuivalen');
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
        Schema::dropIfExists('kegiatan');
    }
}
