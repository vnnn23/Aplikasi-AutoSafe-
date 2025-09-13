<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'id_pengguna';
    protected $table = 'datauser';

    protected $fillable = [
        'nama',
        'telepon',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function getAuthIdentifierName()
    {
        return 'nama';
    }
}