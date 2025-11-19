<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPembayaran extends Model
{
    protected $table = 'bukti_pembayaran';

    protected $fillable = [
        'transaksi_id',
        'file_path',
        'tanggal_upload',
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Relasi ke Transaksi Zakat
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiZakat::class, 'transaksi_id');
    }

    /**
     * Link file bukti pembayaran
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
