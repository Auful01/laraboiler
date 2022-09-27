<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeAlamat extends Model
{
    use HasFactory;

    protected $table = 'tipe_alamat';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
    ];
}
