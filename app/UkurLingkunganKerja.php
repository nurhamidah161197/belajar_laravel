<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UkurLingkunganKerja extends Model
{
    protected $primaryKey = 'id_ukurlingkerja';

    protected $table      = '1000_tb_ukurlingkerja';

    public $timestamps    = false;

    protected $fillable   = [
        'id_ukurlingkerja', 'tanggal', 'id_lokasi', 'kegiatan', 'no_notif', 'kesimpulan', 'rekomendasi','status', 'updated_at', 'status_hapus'
    ];
}
