<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'id' => '1',
            'name' => 'Gustiar Arief Vilana',
            'nik' => '12345',
            'username' => 'admin',
            'level' => '99',
            'email' => 'admin@local.com',
            'password' => bcrypt('admin'),
            'pass' => 'admin',
        ]);

        // jabatan
            $jabatan = [
                [
                'id' => '1',
                'kode_jabatan' => '99',
                'nama_jabatan' => 'Superadmin',
                ],
                [
                'id' => '2',
                'kode_jabatan' => '11',
                'nama_jabatan' => 'Admin',
                ],
                [
                'id' => '3',
                'kode_jabatan' => '12',
                'nama_jabatan' => 'Manager Pusat',
                ],
                [
                'id' => '4',
                'kode_jabatan' => '13',
                'nama_jabatan' => 'Internal Audit',
                ],
                [
                'id' => '5',
                'kode_jabatan' => '14',
                'nama_jabatan' => 'General manager',
                ],
                [
                'id' => '6',
                'kode_jabatan' => '21',
                'nama_jabatan' => 'Kolektor',
                ],
                [
                'id' => '7',
                'kode_jabatan' => '22',
                'nama_jabatan' => 'Verifikator',
                ],
                [
                'id' => '8',
                'kode_jabatan' => '23',
                'nama_jabatan' => 'CCC',
                ],
                [
                'id' => '9',
                'kode_jabatan' => '24',
                'nama_jabatan' => 'Regional CRM',
                ],
                [
                'id' => '10',
                'kode_jabatan' => '25',
                'nama_jabatan' => 'K.Div RCM',
                ],
                [
                'id' => '11',
                'kode_jabatan' => '31',
                'nama_jabatan' => 'Salles',
                ],
                [
                'id' => '12',
                'kode_jabatan' => '32',
                'nama_jabatan' => 'Team Manager',
                ],
                [
                'id' => '13',
                'kode_jabatan' => '23',
                'nama_jabatan' => 'GTM',
                ],
                [
                'id' => '14',
                'kode_jabatan' => '25',
                'nama_jabatan' => 'K.Div Marketing',
                ],
            ];

            foreach ($jabatan as $jabatan_data) {
                DB::table('tbl_jabatan')->insert($jabatan_data);
            }
        // jabatan

        // 
    }
}