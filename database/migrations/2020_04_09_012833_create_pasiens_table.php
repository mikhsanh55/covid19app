<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kabkota');
            $table->integer('id_kecamatan');
            $table->integer('id_kelurahan');
            $table->integer('id_pasien_status');
            $table->string('nama', 100);
            $table->string('nik', 100);
            $table->integer('umur');
            $table->enum('jk', [1, 0]);
            $table->date('tgl_input');
            $table->enum('rawat', [1, 0]);
            $table->string('latitude', 200);
            $table->string('longitude', 200);
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
        Schema::dropIfExists('pasiens');
    }
}
