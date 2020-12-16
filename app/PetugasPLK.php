<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetugasPLK extends Model
{
    protected $primaryKey = 'id_petugas';

    protected $table      = '1004_tb_petugas';

    public $timestamps    = false;

    protected $fillable   = [
        'id_petugas', 'id_ukurlingkerja', 'username', 'status_hapus'
    ];
}
