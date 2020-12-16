<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeteranganLingkuganKerja extends Model
{
    protected $primaryKey = 'id_keterangan';

    protected $table      = '1003_tb_keterangan';

    public $timestamps    = false;

    public $incrementing  = false;

    protected $fillable   = [
        'id_keterangan', 'id_ukurlingkerja', 'id_jenis', 'keterangan'
    ];
}
