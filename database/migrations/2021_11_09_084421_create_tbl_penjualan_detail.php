<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPenjualanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_penjualan_detail', function (Blueprint $table) {
            $table->id();
            
            $table->string('no_kwitansi');
            $table->string('kd_produk');
            $table->double('harga_produk');
            $table->double('jml_barang');
            $table->double('total_harga');

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
        Schema::dropIfExists('tbl_penjualan_detail');
    }
}