<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisZakat extends Model
{
    protected $table = 'jenis_zakat';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'persentase',
        'kadar_zakat',
        'nisab'
    ];

    public $timestamps = false;

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiZakat::class, 'jenis_zakat_id');
    }
}
