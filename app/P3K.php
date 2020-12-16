<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P3K extends Model
{
    protected $primaryKey = 'id_barang';

    protected $table      = '0000_tb_p3k';

    public $timestamps    = false;

    public $incrementing  = false;

    protected $fillable   = [
        'id_barang', 'barang', 'satuan', 'updated_at', 'status_hapus'
    ];
}
