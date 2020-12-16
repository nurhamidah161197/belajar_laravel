<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModul extends Model
{
    protected $primaryKey = 'id';

    protected $table      = 'users_modul';

    public $timestamps    = false;

    protected $fillable   = [
        'id', 'username', 'modul', 'level', 'organisasi', 'status_hapus'
    ];
}
