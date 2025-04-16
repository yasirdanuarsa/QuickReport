<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Crud extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'surat_masuk_path',
        'nomor_telepon',
        'activity',
        'tanggal_laporan',
        'perihal',
        'instansi',
        'hasil',
        'bukti',
        'status',
        'users_id',
    ];
    

    /**
     * Relasi ke user (petugas)
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
