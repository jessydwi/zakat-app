<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
        protected $fillable =
         ['nama_lembaga', 
         'alamat', 'email', 
         'telepon', 'logo', 
         'pesan_notifikasi', 
         'default_role'];
}
