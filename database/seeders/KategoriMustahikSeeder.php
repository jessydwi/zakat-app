<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMustahikSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_mustahik')->insert([
            [
                'id' => 1,
                'nama_kategori' => 'Fakir',
                'deskripsi' => 'Tidak memiliki harta dan penghasilan tetap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_kategori' => 'Miskin',
                'deskripsi' => 'Penghasilan tidak mencukupi kebutuhan dasar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama_kategori' => 'Amil',
                'deskripsi' => 'Petugas pengelola zakat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
