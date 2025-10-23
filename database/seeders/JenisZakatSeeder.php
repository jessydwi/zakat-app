<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisZakatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_zakat')->insert([
            [
                'nama_jenis' => 'Zakat Fidyah',
                'deskripsi' => 'Pengganti puasa bagi yang tidak mampu',
                'kadar_zakat' => 0.00,
                'nisab' => 0.00,
            ],
            [
                'nama_jenis' => 'Zakat Mal',
                'deskripsi' => 'Zakat atas harta simpanan',
                'kadar_zakat' => 2.50,
                'nisab' => 85000000.00,
            ],
            [
                'nama_jenis' => 'Zakat Fitrah',
                'deskripsi' => 'Zakat wajib di akhir Ramadhan',
                'kadar_zakat' => 0.00,
                'nisab' => 0.00,
            ],
            [
                'nama_jenis' => 'Infak',
                'deskripsi' => 'Sumbangan sukarela di luar zakat wajib',
                'kadar_zakat' => 0.00,
                'nisab' => 0.00,
            ],
        ]);
    }
}
