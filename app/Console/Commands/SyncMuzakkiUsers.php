<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Muzakki;

class SyncMuzakkiUsers extends Command
{
    protected $signature = 'app:sync-muzakki-users';
    protected $description = 'Command description';

    public function handle()
    {
    $users = User::role('muzakki')->get();

    foreach ($users as $user) {
        Muzakki::updateOrCreate(
            ['user_id' => $user->id],
            ['nama' => $user->name, 'email' => $user->email]
        );
    }

    $this->info('Sinkronisasi selesai!');
    }
}
