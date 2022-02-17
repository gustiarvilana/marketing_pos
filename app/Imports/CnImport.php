<?php

namespace App\Imports;

use App\Models\CnModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CnImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tahun =session('tahun');
        $periode =session('periode');
        $now = date('Ymd');
        // dd($now);

        return new CnModel([
            'tahun'             => $tahun,
            'periode'           => $periode,
            'tgl_penarikan'     => $row[2],
            'nosp'              => $row[3],
            'no_kwitasi'        => $row[4],
            'nm_customer'       => $row[5],
            'alamat'            => $row[6],
            'no_tlp'            => $row[7],
            'cicil_ke'          => $row[8],
            'kd_produk'         => $row[9],
            'nama_produk'       => $row[10],
            'jml_brg_ditarik'   => $row[11],
            'nominal'           => $row[12],
            'sales'             => $row[13],
            'nama'              => $row[14],
            'koordinator'       => $row[15],
            'supervisor_mrk'    => $row[16],
            'kadiv'             => $row[17],
            'verifikator'       => $row[18],
            'ket'               => $row[19],
            'date_input'        => $now,
        ]);
    }
}