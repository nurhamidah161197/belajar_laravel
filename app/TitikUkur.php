<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TitikUkur extends Model
{
    protected $primaryKey = 'id_titikukur';

    protected $table      = '0000_tb_titikukur';

    public $timestamps    = false;

    protected $fillable   = [
        'id_titikukur', 'id_lokasi', 'titik_ukur', 'status_hapus'
    ];
}
