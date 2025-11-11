<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            KategoriMustahikSeeder::class,
            MustahikSeeder::class,
        ]);

        $user = User::create([
        'name' => 'Cinta Anastasya',
        'email' => 'cinta@zakat.com',
        'password' => Hash::make('cinta123'),
        'role' => 'muzakki',
        ]);

        Muzakki::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'no_hp' => '081234567890',
        ]);
    }

}
