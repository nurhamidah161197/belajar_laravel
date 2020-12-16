<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisUkur extends Model
{
    protected $primaryKey = 'id';

    protected $table      = '0000_tb_jenisukur';

    public $timestamps    = false;

    protected $fillable   = [
        'id', 'jenis', 'satuan', 'updated_at', 'status_hapus'
    ];
}
