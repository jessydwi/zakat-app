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
        'nama',
        'jenis_kelamin',
        'kontak',
        'detail',
        'amil_id',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'detail' => 'array',
    ];

    public $timestamps = true;

    // Relasi ke tabel muzakki
    public function muzakki(): BelongsTo
    {
        return $this->belongsTo(Muzakki::class, 'muzakki_id');
    }

    // Relasi ke jenis zakat
    public function jenisZakat(): BelongsTo
    {
        return $this->belongsTo(JenisZakat::class, 'jenis_zakat_id');
    }

    // Relasi ke metode pembayaran
    public function metodePembayaran(): BelongsTo
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }

    // Relasi ke bukti pembayaran
    public function buktiPembayaran()
    {
        return $this->hasOne(BuktiPembayaran::class, 'transaksi_id');
    }

    // Relasi ke amil (yang mengkonfirmasi transaksi)
    public function amil(): BelongsTo
    {
        return $this->belongsTo(Amil::class, 'amil_id');
    }

    // Jika ingin relasi ke user (berdasarkan muzakki_id)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'muzakki_id');
    }
}
