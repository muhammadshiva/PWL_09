<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelasiKelasMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table){
            $table->dropColumn('kelas'); // Menghapus kolom kelas 
            $table->unsignedBigInteger('kelas_id'); // Menambahkan kolom kelas_id
            $table->foreign('kelas_id')->references('id')->on('kelas'); // Menambahkan foreign key di kolom kelas_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table){
            $table->string('kelas');
            $table->dropForeign('kelas_id');
        });
    }
}