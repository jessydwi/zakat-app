<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Muzakki extends Model
{
    protected $table = 'muzakki';

    protected $fillable = [
        'user_id',
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

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriMustahik::class, 'kategori_id');
    }

    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }

}
