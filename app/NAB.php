<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NAB extends Model
{
    protected $primaryKey = 'id';

    protected $table      = '0000_tb_nab';

    public $timestamps    = false;

    protected $fillable   = [
        'id', 'no_surat', 'tanggal', 'updated_at', 'status_hapus'
    ];
}
