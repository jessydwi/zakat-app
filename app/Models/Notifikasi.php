<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'status_baca',
        'tanggal',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // App\Models\Notifikasi.php
public function pengirim()
{
    return $this->belongsTo(User::class, 'sender_id');
}

}
