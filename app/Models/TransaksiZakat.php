<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiZakat extends Model
{
    protected $table = 'transaksi_zakat';

    protected $fillable = [
        'muzakki_id',
        'jenis_zakat_id',
        'metode_id',
        'nominal',
        'tanggal',
        'status',
    ];

    public $timestamps = true;

    // Relasi ke muzakki
    public function muzakki(): BelongsTo
    {
        return $this->belongsTo(Muzakki::class);
    }

    // Relasi ke jenis zakat
    public function jenisZakat(): BelongsTo
    {
        return $this->belongsTo(JenisZakat::class);
    }

    // Relasi ke metode pembayaran
    public function metodePembayaran(): BelongsTo
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }
}
