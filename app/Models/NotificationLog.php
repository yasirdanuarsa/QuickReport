<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = [
        'crud_id', 'status', 'sent_at'
    ];

    public function laporan()
    {
        return $this->belongsTo(Crud::class, 'crud_id');
    }
}
