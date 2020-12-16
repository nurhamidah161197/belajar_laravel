<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UkurLingkunganKerja;
use App\Organisasi;
use App\JenisUkur;
use App\LokUkurLingkunganKerja;
use App\HasilUkurLingKerja;
use App\TitikUkur;
use App\NAB;
use DB;

class lapLingkunganKerjaController extends Controller
{
    public function index($id)
    {
        $header_page  = "page_laporan";
        $page         = "page_laporanpengukuranlingkerja";

        $master       = DB::select("SELECT tu.id_ukurlingkerja,
                                           DATE_FORMAT(tu.tanggal, '%d.%m.%Y') AS tanggal,
                                           tu.id_lokasi,
                                           tor.lokasi,
                                           tu.kegiatan,
                                           (CASE
                                               WHEN tu.kegiatan = 0 THEN 'RUTIN'
                                               WHEN tu.kegiatan = 1 THEN 'NON RUTIN'
                                            END) AS kegiatan_desc,
                                           tu.no_notif,
                                           tu.status,
                                           (CASE
                                               WHEN tu.status = 1 THEN 'OPEN'
                                               WHEN tu.status = 2 THEN 'RELEASE'
                                               WHEN tu.status = 3 THEN 'APPROVED BY ADMIN'
                                               WHEN tu.status = 4 THEN 'APPROVED BY USER'
                                            END) AS status_desc,
                                           tu.kesimpulan,
                                           tu.rekomendasi,
                                           tu.tindaklanjut
                                    FROM 1000_tb_ukurlingkerja tu
                                    LEFT JOIN 0000_tb_organisasi tor ON tor.id_lokasi = tu.id_lokasi
                                    WHERE tu.status_hapus = 1 AND tu.id_ukurlingkerja = '".$id."'");

        $lokasi       = Organisasi::where('status_hapus', 1)->get();


        // DB::enableQueryLog();

        $lokasiukur   = DB::select("SELECT tl.*, tu.titik_ukur AS lokasi_ukur
                                    FROM ".config('constants.tb_lokukurlingkerja')." tl
                                    INNER JOIN ".config('constants.tb_titikukur')." tu ON tu.id_titikukur = tl.id_titikukur
                                    WHERE tl.status_hapus = 1 AND tl.id_ukurlingkerja = '".$id."'");



        // dd($lokasiukur);

        $titikukur    = TitikUkur::where('status_hapus', 1)
                                 ->where('id_lokasi', $master[0]->id_lokasi)
                                 ->get();

        DB::enableQueryLog();



        $nab          = DB::select("SELECT *
                                    FROM ".config('constants.tb_nab')."
                                    WHERE tanggal = ( SELECT MAX(tanggal) FROM ".config('constants.tb_nab')." WHERE tanggal <= '".date("Y-m-d", strtotime($master[0]->tanggal))."' AND status_hapus = 1)");

        // dd(DB::getQueryLog());
        // dd($nab);
        // DB::enableQueryLog();
        $data         = DB::select("SELECT th.*, tj.jenis, tj.satuan, tnn.nab
                                    FROM ".config('constants.tb_ukurlingkerja')." tu
                                    RIGHT JOIN ".config('constants.tb_lokukurlingkerja')." tl ON tl.id_ukurlingkerja = tu.id_ukurlingkerja
                                    RIGHT JOIN ".config('constants.tb_hasukurlingkerja')." th ON th.id_lokukurlingkerja = tl.id_lokukurlingkerja AND th.status_hapus = 1
                                    INNER JOIN ".config('constants.tb_jenis_ukur')." tj ON tj.id = th.id_jenis
                                    INNER JOIN ".config('constants.tb_nilainab')." tnn ON tnn.id_jenis = th.id_jenis
                                    WHERE tu.id_ukurlingkerja = '".$id."' AND tu.status_hapus = 1
                                    ORDER BY th.id_hasilukurlingkerja"
                                   );

        // dd($data);

        $data_jns    = array();
        $data_hasil  = array();
        $data_nab    = array();
        foreach($data as $data) {

            $data_jns[$data->id_lokukurlingkerja][$data->id_hasilukurlingkerja] = $data->jenis;
            if($data->keterangan!=""){
                $data_hasil[$data->id_lokukurlingkerja][$data->id_hasilukurlingkerja] = $data->hasil." ".$data->satuan." # ".$data->keterangan;
            }else{
                $data_hasil[$data->id_lokukurlingkerja][$data->id_hasilukurlingkerja] = $data->hasil." ".$data->satuan;
            }
            $data_nab[$data->id_lokukurlingkerja][$data->id_hasilukurlingkerja] = $data->nab." ".$data->satuan;

        }
        // dd(DB::getQueryLog());

        $jenis        = JenisUkur::where('status_hapus', 1)->get();

        return view('views.lapLingkunganKerja', [ 'master'      => $master[0],
                                                  'nab'         => $nab[0],
                                                  'lokasi'      => $lokasi,
                                                  'titikukur'   => $titikukur,
                                                  'lokasiukur'  => $lokasiukur,
                                                  'jenis'       => $jenis,
                                                  'data_jns'    => $data_jns,
                                                  'data_hasil'  => $data_hasil,
                                                  'data_nab'    => $data_nab,
                                                  'header_page' => $header_page,
                                                  'page'        => $page
                                                ]);
    }

    public function getlokasi($id)
    {
        $data = LokUkurLingkunganKerja::where('id_lokukurlingkerja', $id)->first();

        return response()->json(['data' => $data]);
    }

    public function gettitik($id)
    {
        $data = TitikUkur::where('id_lokasi', $id)
                         ->where('status_hapus', 1)
                         ->get();

        return response()->json(['data' => $data]);
    }

    public function getlokukur($id)
    {
        DB::enableQueryLog();
        $data   = DB::select("SELECT tl.*, tu.titik_ukur
                              FROM ".config('constants.tb_lokukurlingkerja')." tl
                              INNER JOIN ".config('constants.tb_titikukur')." tu ON tu.id_titikukur = tl.id_titikukur
                              WHERE tl.status_hapus = 1 AND tl.id_ukurlingkerja = '".$id."'");

        // dd(DB::getQueryLog());

        return response()->json(['data' => $data]);
    }

    public function storetitik(Request $request)
    {

        TitikUkur::where('id_lokasi', $request->id_lokasi)->update(['status_hapus' => '0']);

        $lokasi = json_decode($request->lokasi);
        foreach($lokasi as $lokasi)
        {
            $id = "";
            if(isset($lokasi->id_titikukur)){
                $id       = $lokasi->id_titikukur;
            }

            if(!empty(trim($request->lokasi))){
                TitikUkur::updateOrCreate(
                   [
                     'id_titikukur'      => $id
                   ],
                   [
                     'id_lokasi'         => $request->id_lokasi,
                     'titik_ukur'        => $lokasi->titik_ukur,
                     'status_hapus'      => 1
                   ]
                );
            }
         }
    }

    public function storelokasi(Request $request)
    {
        LokUkurLingkunganKerja::where('id_ukurlingkerja', $request->id_ukurlingkerja)->update(['status_hapus' => '0']);

        $lokasi = json_decode($request->lokasi);
        foreach($lokasi as $lokasi)
        {
            $id = "";
            if(isset($lokasi->id_lokukurlingkerja)){
                $id       = $lokasi->id_lokukurlingkerja;
            }

            LokUkurLingkunganKerja::updateOrCreate(
               [
                 'id_lokukurlingkerja'      => $id
               ],
               [
                 'id_ukurlingkerja'         => $request->id_ukurlingkerja,
                 'id_titikukur'             => $lokasi->id_titikukur,
                 'status_hapus'             => 1
               ]
            );
        }
    }

    public function gethasil($id)
    {
        DB::enableQueryLog();
        $data = DB::select("SELECT th.*, tj.jenis, tj.satuan
                            FROM ".config('constants.tb_hasukurlingkerja')." th
                            INNER JOIN ".config('constants.tb_jenis_ukur')." tj ON tj.id = th.id_jenis
                            WHERE th.id_lokukurlingkerja = '".$id."' AND th.status_hapus = 1");

        // dd(DB::getQueryLog());

        return response()->json(['data' => $data]);

    }

    public function storehasil(Request $request)
    {
        HasilUkurLingKerja::where('id_lokukurlingkerja', $request->id_lokukurlingkerja)->update(['status_hapus' => '0']);

        $data = json_decode($request->data);

        foreach($data as $data){

            $id = '';
            if(isset($data->id_hasilukurlingkerja)){
                $id       = $data->id_hasilukurlingkerja;
            }

            HasilUkurLingKerja::updateOrCreate(
               [
                 'id_hasilukurlingkerja'       => $id
               ],
               [
                 'id_lokukurlingkerja'         => $request->id_lokukurlingkerja,
                 'id_jenis'                    => $data->id_jenis,
                 'hasil'                       => $data->hasil,
                 'keterangan'                  => $data->keterangan,
                 'status_hapus'                => 1
               ]
            );
        }
    }
}
