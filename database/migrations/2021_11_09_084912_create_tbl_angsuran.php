<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAngsuran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_angsuran', function (Blueprint $table) {
            $table->id();
            
            $table->string('no_kwitansi');
            $table->double('angsuran_ke');
            $table->double('thn_bulan');
            $table->double('oustanding');
            $table->double('angsuran');
            $table->double('nominal_bayar');
            $table->double('nominal_sisa');
            $table->double('tgl_bayar');
            $table->double('sts_bayar');
            $table->double('sts_cetak');
            
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
        Schema::dropIfExists('tbl_angsuran');
    }
}