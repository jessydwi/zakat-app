<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mustahik extends Model
{
    protected $table = 'mustahik';

    protected $fillable = [
        'nama',
        'alamat',
        'kategori_id',
        'no_hp',
        'status_penyaluran',
    ];

    public $timestamps = true;

    public function kategori()
    {
        return $this->belongsTo(KategoriMustahik::class, 'kategori_id');
    }
}
