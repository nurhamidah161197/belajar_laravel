<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilInspeksiP3K extends Model
{
    protected $primaryKey = 'id_hasilinspeksip3k';

    protected $table      = '2001_tb_hasilinspeksip3k';

    public $timestamps    = false;

    public $incrementing  = false;

    protected $fillable   = [
        'id_hasilinspeksip3k', 'id_inspeksip3k', 'id_barang', 'jumlah', 'kondisi', 'keterangan', 'status_hapus'
    ];
}
