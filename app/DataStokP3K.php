<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataStokP3K extends Model
{
    protected $primaryKey = 'id';

    protected $table      = '2002_tb_datastokp3k';

    public $timestamps    = false;

    public $incrementing  = false;

    protected $fillable   = [
        'id', 'id_barang', 'stok', 'keterangan', 'tgl_update'
    ];
}
