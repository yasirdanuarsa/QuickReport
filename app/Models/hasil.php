<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class hasil extends Model
{
    use HasFactory;

    protected $fillable = ["laporan", "tanggal_pelaporan"];
}
