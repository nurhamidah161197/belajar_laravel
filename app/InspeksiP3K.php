<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiP3K extends Model
{
    protected $primaryKey = 'id';

    protected $table      = '2000_tb_inspeksip3k';

    public $timestamps    = true;

    public $incrementing  = true;

    protected $fillable   = [
        'id', 'id_lokasi', 'representatif', 'periode', 'tanggal', 'status', 'status_hapus'
    ];
}
