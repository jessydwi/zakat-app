<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\KategoriMustahik;


class DistribusiZakat extends Model
{
    protected $table = 'distribusi_zakat';

    protected $fillable = [
        'mustahik_id',
        'jenis_bantuan_id',
        'jumlah',
        'tanggal',
        'status',
        'detail_json', 
    ];

    public $timestamps = true;

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah' => 'decimal:2',
        'detail_json' => 'array',
    ];

    // Relasi ke Mustahik
    public function mustahik(): BelongsTo
    {
        return $this->belongsTo(Mustahik::class);
    }

    // Relasi ke Jenis Bantuan
    public function jenisBantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }

    public function kategoriMustahik()
    {
        return $this->belongsTo(KategoriMustahik::class, 'kategori_mustahik_id');
    }

}
