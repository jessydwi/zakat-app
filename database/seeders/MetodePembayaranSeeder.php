<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodePembayaranSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data lama dan reset ID
        DB::table('metode_pembayaran')->truncate();

        // Isi ulang data awal
        DB::table('metode_pembayaran')->insert([
            [
                'nama_metode' => 'Transfer Bank',
                'deskripsi' => 'Pembayaran via rekening bank',
                'status_aktif' => true,
            ],
            [
                'nama_metode' => 'Tunai',
                'deskripsi' => 'Pembayaran langsung ke kantor',
                'status_aktif' => true,
            ],
            [
                'nama_metode' => 'QRIS',
                'deskripsi' => 'Pembayaran melalui scan QR',
                'status_aktif' => true,
            ],
        ]);
    }
}
