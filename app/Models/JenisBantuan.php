<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBantuan extends Model
{
    protected $table = 'jenis_bantuan'; // Nama tabel manual

    protected $fillable = [
        'nama_bantuan',
        'deskripsi',
        'slug',
    ];

    public $timestamps = true; // Karena kamu punya created_at dan updated_at
}

