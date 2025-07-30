<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', // tambahkan 'role' di sini
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function laporan()
    {
        return $this->hasMany(Crud::class, 'petugas_id');
        return $this->hasMany(\App\Models\Crud::class, 'users_id');
    }
    
     
}
