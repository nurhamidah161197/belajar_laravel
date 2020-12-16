<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LokUkurLingkunganKerja extends Model
{
    protected $primaryKey = 'id_lokukurlingkerja';

    protected $table      = '1001_tb_lokukurlingkerja';

    public $timestamps    = false;

    protected $fillable   = [
        'id_lokukurlingkerja', 'id_ukurlingkerja', 'id_titikukur', 'status_hapus'
    ];

}
