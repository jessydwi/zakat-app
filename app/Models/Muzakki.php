<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Muzakki extends Model
{
    protected $table = 'muzakki';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'pekerjaan',
    ];

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiZakat::class, 'muzakki_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriMustahik::class, 'kategori_id');
    }

}
