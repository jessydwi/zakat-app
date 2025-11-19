<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amil extends Model
{
    use HasFactory;

    protected $table = 'amil';

    protected $fillable = [
        'user_id',
        'jabatan',
        'wilayah_tugas',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
