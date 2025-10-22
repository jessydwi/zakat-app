<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransaksiZakat;

class TransaksiZakatSeeder extends Seeder
{
    public function run(): void
    {
        TransaksiZakat::create([
            'muzakki_id' => 1,
            'jenis_zakat_id' => 2,
            'metode_id' => 1,
            'nominal' => 500000,
            'tanggal' => now(),
            'status' => 'menunggu',
        ]);
    }
}
