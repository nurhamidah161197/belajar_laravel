<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $primaryKey = 'id_lokasi';

    protected $table      = '0000_tb_organisasi';

    public $timestamps    = false;

    public $incrementing  = false;

    protected $fillable   = [
        'id_lokasi', 'lokasi', 'modul', 'updated_at', 'status_hapus'
    ];
}
