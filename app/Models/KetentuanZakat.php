<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetentuanZakat extends Model
{
        protected $table = 'ketentuan_zakat';
        protected $fillable = ['jenis_zakat', 
        'parameter', 
        'satuan', 
        'nilai', 
        'keterangan'];
}
