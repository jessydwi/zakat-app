<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMustahik extends Model
{
    protected $table = 'kategori_mustahik';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public $timestamps = true;

    // Relasi ke Mustahik
    public function mustahik()
    {
        return $this->hasMany(Mustahik::class, 'kategori_id');
    }
}
