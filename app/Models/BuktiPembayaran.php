<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPembayaran extends Model
{
    protected $table = 'bukti_pembayaran';

    protected $fillable = [
        'transaksi_id',
        'file',
        'tanggal_upload',
    ];

    protected $appends = ['file_url', 'file_path'];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    public $timestamps = true;

    public function getFilePathAttribute()
    {
        return 'storage/bukti/' . $this->file;
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiZakat::class, 'transaksi_id');
    }

    /**
     * Link file bukti pembayaran
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/bukti' . $this->file);
    }
}
