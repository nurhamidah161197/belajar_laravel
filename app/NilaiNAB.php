<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiNAB extends Model
{
    protected $primaryKey = 'id';

    protected $table      = '0000_tb_nilainab';

    public $timestamps    = false;

    public $incrementing  = false;

    protected $fillable   = [
        'id', 'id_surat', 'id_jenis', 'nab', 'updated_at', 'status_hapus'
    ];
}
