<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBantuan;

class JenisBantuanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_bantuan' => 'Sembako',
                'slug' => 'sembako',
                'deskripsi' => 'Paket sembako untuk mustahik',
            ],
            [
                'nama_bantuan' => 'Uang Tunai',
                'slug' => 'uang-tunai',
                'deskripsi' => 'Bantuan langsung berupa uang',
            ],
            [
                'nama_bantuan' => 'Beasiswa',
                'slug' => 'beasiswa',
                'deskripsi' => 'Bantuan pendidikan untuk anak mustahik',
            ],
            [
                'nama_bantuan' => 'Modal Usaha',
                'slug' => 'modal-usaha',
                'deskripsi' => 'Dukungan usaha kecil untuk mustahik produktif',
            ],
            [
                'nama_bantuan' => 'Kesehatan',
                'slug' => 'kesehatan',
                'deskripsi' => 'Bantuan biaya pengobatan atau alat kesehatan',
            ],
        ];

        foreach ($data as $item) {
            JenisBantuan::updateOrCreate(
                ['nama_bantuan' => $item['nama_bantuan']],
                $item
            );
        }
    }
}
