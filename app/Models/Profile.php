<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profile';
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'telepon',
        'foto',
        'kyc_file',
        'no_ktp',
        'verifikasi',
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
