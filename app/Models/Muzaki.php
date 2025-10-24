<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Muzaki extends Model
{
    protected $table = 'muzakki';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'pekerjaan',
    ];

    public $timestamps = true;

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiZakat::class, 'muzaki_id');
    }
}
