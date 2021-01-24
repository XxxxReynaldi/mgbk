<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->bigInteger('id_user');
            $table->bigInteger('id_sekolah');
            $table->bigInteger('id_kegiatan');
            $table->date('tgl_transaksi');
            $table->text('detail');
            $table->string('upload_doc');
            $table->timestamps();
        });

        Schema::create('sekolah_baru', function (Blueprint $table) {
            $table->id('id_sekolah_baru');
            $table->string('nama_sekolah');
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
        Schema::dropIfExists('laporan');
    }
}
