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
<<<<<<< HEAD
        'amil_id',
        'bukti_pembayaran',

=======
>>>>>>> 179287d610194bf813729e6a42cd2200e56b1424
    ];

    protected $casts = [
        'detail' => 'array',
    ];

    public $timestamps = true;

    public function muzakki(): BelongsTo
    {
        return $this->belongsTo(Muzakki::class, 'muzakki_id');
    }

    public function jenisZakat(): BelongsTo
    {
        return $this->belongsTo(JenisZakat::class, 'jenis_zakat_id');
    }

    public function metodePembayaran(): BelongsTo
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }

    public function buktiPembayaran()
    {
        return $this->hasOne(BuktiPembayaran::class, 'transaksi_id');
    }

    public function amil()
{
    return $this->belongsTo(\App\Models\Amil::class);
}

}
