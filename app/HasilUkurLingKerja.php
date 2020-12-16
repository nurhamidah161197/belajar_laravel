<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilUkurLingKerja extends Model
{
    protected $primaryKey = 'id_hasilukurlingkerja';

    protected $table      = '1002_tb_hasilukurlingkerja';

    public $timestamps    = false;

    protected $fillable   = [
        'id_hasilukurlingkerja', 'id_lokukurlingkerja', 'id_jenis', 'hasil', 'keterangan', 'status_hapus'
    ];
}
