<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('id_profile');
            $table->integer('id_user');
            $table->string('nama_lengkap');
            $table->string('alamat_sekolah');
            $table->string('nama_kepala_sekolah');
            $table->string('asal_sekolah');
            $table->string('tambahan_informasi');
            $table->string('logo_sekolah');
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
        Schema::dropIfExists('profiles');
    }
}
