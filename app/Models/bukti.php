<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bukti extends Model
{
    use HasFactory;

    protected $fillable = ["file_bukti", "keterangan"];
}
