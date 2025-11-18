<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MetodePembayaran;


class TransaksiZakat extends Model
{
    protected $table = 'transaksi_zakat';

    protected $fillable = [
        'id_muzakki',
        'jenis_zakat_id',
        'metode_id',
        'nominal',
        'tanggal',
        'status',
        'nama',
        'jenis_kelamin',
        'kontak',
        'detail',
        'bukti_pembayaran',
    ];

    protected $casts = [
    'detail' => 'array', // ✅ otomatis konversi array ke JSON
];

    public $timestamps = true;

    public function muzakki(): BelongsTo
    {
        return $this->belongsTo(Muzakki::class, 'muzaki_id');
    }

    public function jenisZakat(): BelongsTo
    {
        return $this->belongsTo(JenisZakat::class, 'jenis_zakat_id');
    }

    // Relasi ke metode pembayaran
    public function metodePembayaran(): BelongsTo
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }
    public function buktiPembayaran()
    {
        return $this->hasOne(BuktiPembayaran::class, 'transaksi_id');
    }
}
