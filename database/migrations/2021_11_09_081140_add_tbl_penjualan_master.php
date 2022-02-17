<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTblPenjualanMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_penjualan_master', function (Blueprint $table) {
            $table->id();

            $table->string('no_kwitansi')->nullable();
            $table->string('no_sp')->nullable();
            $table->string('nama_customer')->nullable();
            $table->string('alamat')->nullable();
            $table->string('alamat2')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('sts_beli')->nullable();
            $table->double('tgl_jual')->nullable();
            $table->double('tgl_jt_tempo')->nullable();
            $table->string('sts_angsuran')->nullable();
            $table->double('dp')->nullable();
            $table->double('lama_angsur')->nullable();
            $table->double('besar_angsur_bln')->nullable();
            $table->double('total_harga')->nullable();
            
            $table->double('jml_ygtelah_dibayar')->nullable();
            $table->double('ket_cicil_ke')->nullable();
            $table->string('ket')->nullable();
            $table->string('sts_print')->nullable();
            $table->double('tgl_print')->nullable();
            $table->double('nominal_angsur_per_jt')->nullable();
            $table->double('sisa_rp')->nullable();
            
            $table->string('sales')->nullable();
            $table->string('verifikator')->nullable();
            $table->double('tgl_verif')->nullable();
            $table->string('t_manager')->nullable();
            $table->string('gt_manager')->nullable();
            $table->string('kdiv_marketing')->nullable();
            $table->string('sts_flow')->nullable();
            
            $table->string('kd_kolektor')->nullable();
            
            $table->string('kd_driver')->nullable();
            $table->double('tgl_delivery')->nullable();
            $table->string('kd_helper')->nullable();
                        
            $table->string('sts_tagih_colector')->nullable();
            $table->string('batch_user')->nullable();
            $table->string('sts_os')->nullable();
            $table->string('sts_kwt')->nullable();
            $table->string('jnskon')->nullable();
            $table->string('nosp_induk')->nullable();
            $table->string('nova')->nullable();
            $table->double('tglbyrakh')->nullable();
            $table->double('thnblnbyrakh')->nullable();

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
        Schema::dropIfExists('tbl_penjualan_master');
    }
}