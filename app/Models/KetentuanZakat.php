<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetentuanZakat extends Model
{
    protected $table = 'ketentuan_zakat';

    protected $fillable = [
        'jenis_zakat',
        'parameter',
        'satuan',
        'nilai',
        'nilai_uang',
        'keterangan',
    ];

    protected $casts = [
        'nilai' => 'float',
        'nilai_uang' => 'float',
    ];

    public $timestamps = true;
}
