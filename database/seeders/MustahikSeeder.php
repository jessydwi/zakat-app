<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mustahik;

class MustahikSeeder extends Seeder
{
    public function run()
{
    Mustahik::create([
        'nama' => 'Pak Ahmad',
        'kategori_id' => 1,
        'alamat' => 'Jl. Kenanga No. 10, Jakarta',
        'no_hp' => '081234567890',
        'status_penyaluran' => 'Aktif',
    ]);

    Mustahik::create([
        'nama' => 'Bu Siti',
        'kategori_id' => 2,
        'alamat' => 'Jl. Melati No. 45, Bandung',
        'no_hp' => '082345678901',
        'status_penyaluran' => 'Aktif',
    ]);
}

}

