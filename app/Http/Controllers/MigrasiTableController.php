<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BPKTindakLanjut;
use App\KAPTindakLanjut;
use App\BPKPTindakLanjut;

use DB;

class MigrasiTableController extends Controller
{
    function kode($inisial, $angka){

        $tmp	= "";
        for($i=1; $i<=(15-strlen($inisial)-strlen($angka)); $i++) {
            $tmp = $tmp."0";
        }

        return $inisial.$tmp.$angka;
    }

    public function rekomendasibpk()
    {
        $rekomendasi = DB::select(" SELECT rb.*, mb.anper
                                    FROM ".config('constants.tb_rekomendasibpk')." rb
                                    RIGHT JOIN ".config('constants.tb_masterbpk')." mb ON mb.id_master_bpk = rb.id_master_bpk
                                    WHERE rb.status_hapus = 1");

        $angka  = 1;
        $rek    = array();
        foreach ($rekomendasi as $rekomendasi) {

            $data['id_rekomendasitl_bpk']  = $this->kode('TB', $angka);
            $data['id_rekomendasi_bpk']    = $rekomendasi->id_rekomendasi_bpk;
            $data['organisasi']            = $rekomendasi->anper;
            $data['tindak_lanjut']         = $rekomendasi->tindak_lanjut;
            $data['tindak_lanjut_temp']    = $rekomendasi->tindak_lanjut;

            array_push($rek, $data);

            $angka++;
        }

        foreach ($rek as $rek){

            BPKTindakLanjut::updateOrCreate(
               [ 'id_rekomendasitl_bpk'   => $rek['id_rekomendasitl_bpk']],
               [
                 'id_rekomendasi_bpk'     => $rek['id_rekomendasi_bpk'],
                 'organisasi'             => $rek['organisasi'],
                 'tindak_lanjut'          => $rek['tindak_lanjut'],
                 'tindak_lanjut_temp'     => $rek['tindak_lanjut_temp'],
               ]
            );
        }
    }

    public function rekomendasikap()
    {
        $rekomendasi = DB::select(" SELECT rb.*, mb.organisasi
                                    FROM ".config('constants.tb_rekomendasikap')." rb
                                    RIGHT JOIN ".config('constants.tb_masterkap')." mb ON mb.id_master_kap = rb.id_master_kap
                                    WHERE rb.status_hapus = 1");

        // dd($rekomendasi);

        $angka  = 1;
        $rek    = array();
        foreach ($rekomendasi as $rekomendasi) {

            $data['id_rekomendasitl_kap']  = $this->kode('TB', $angka);
            $data['id_rekomendasi_kap']    = $rekomendasi->id_rekomendasi_kap;
            $data['organisasi']            = $rekomendasi->organisasi;
            $data['tindak_lanjut']         = $rekomendasi->tindak_lanjut;
            $data['tindak_lanjut_temp']    = $rekomendasi->tindak_lanjut;

            array_push($rek, $data);

            $angka++;
        }

        // dd($rek);

        foreach ($rek as $rek){

            KAPTindakLanjut::updateOrCreate(
               [ 'id_rekomendasitl_kap'   => $rek['id_rekomendasitl_kap']],
               [
                 'id_rekomendasi_kap'     => $rek['id_rekomendasi_kap'],
                 'organisasi'             => $rek['organisasi'],
                 'tindak_lanjut'          => $rek['tindak_lanjut'],
                 'tindak_lanjut_temp'     => $rek['tindak_lanjut_temp'],
               ]
            );
        }
    }

    public function rekomendasibpkp()
    {
        $rekomendasi = DB::select(" SELECT rb.*, mb.organisasi
                                    FROM ".config('constants.tb_rekomendasibpkp')." rb
                                    RIGHT JOIN ".config('constants.tb_masterbpkp')." mb ON mb.id_master_bpkp = rb.id_master_bpkp
                                    WHERE rb.status_hapus = 1");

        // dd($rekomendasi);

        $angka  = 1;
        $rek    = array();
        foreach ($rekomendasi as $rekomendasi) {

            $data['id_rekomendasitl_bpkp']  = $this->kode('TB', $angka);
            $data['id_rekomendasi_bpkp']    = $rekomendasi->id_rekomendasi_bpkp;
            $data['organisasi']             = $rekomendasi->organisasi;
            $data['tindak_lanjut']          = $rekomendasi->tindak_lanjut;
            $data['tindak_lanjut_temp']     = $rekomendasi->tindak_lanjut;

            array_push($rek, $data);

            $angka++;
        }

        // dd($rek);

        foreach ($rek as $rek){

            BPKPTindakLanjut::updateOrCreate(
               [ 'id_rekomendasitl_bpkp'  => $rek['id_rekomendasitl_bpkp']],
               [
                 'id_rekomendasi_bpkp'    => $rek['id_rekomendasi_bpkp'],
                 'organisasi'             => $rek['organisasi'],
                 'tindak_lanjut'          => $rek['tindak_lanjut'],
                 'tindak_lanjut_temp'     => $rek['tindak_lanjut_temp'],
               ]
            );
        }
    }
}
