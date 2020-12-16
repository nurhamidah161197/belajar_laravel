<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UkurLingkunganKerja;
use App\Organisasi;
use App\User;
use App\PetugasPLK;
use DB;
use Datatables;
use DateTime;
use Session;

class listLingkunganKerjaController extends Controller
{
    public function index()
    {
        $header_page  = "page_laporan";
        $page         = "page_laporanpengukuranlingkerja";

        $lokasi       = Organisasi::where('status_hapus', 1)
                                  ->where('modul', 2)
                                  ->get();

        $user         = DB::select("SELECT *
                                    FROM  ".config('constants.tb_user')."
                                    WHERE status_hapus = 1 AND level_admin IN (1,2)");

        return view('views.listLingkunganKerja', [ 'lokasi'        => $lokasi,
                                                   'user'          => $user,
                                                   'header_page'   => $header_page,
                                                   'page'          => $page
                                                 ]);
    }

    public function getdata()
    {
        $subquery = "";
        if(in_array(Session::get('level[2]'), [1,2])){
            $subquery = "AND tu.id_lokasi = '".Session::get('organisasi[2]')."' AND tu.status > 2";
        }

        $data = DB::select(" SELECT tu.id_ukurlingkerja,
                             DATE_FORMAT(tu.tanggal, '%d.%m.%Y') AS tanggal,
                             tl.lokasi as desc_lokasi,
                             (CASE
                                   WHEN tu.kegiatan = 0 THEN 'RUTIN'
                                   WHEN tu.kegiatan = 1 THEN 'NON RUTIN'
                                   END) AS kegiatan,
                             tu.no_notif,
                             (CASE
                                   WHEN tu.status = 1 THEN 'OPEN'
                                   WHEN tu.status = 2 THEN 'RELEASE'
                                   WHEN tu.status = 3 THEN 'APPROVED BY ADMIN'
                                   WHEN tu.status = 4 THEN 'APPROVED BY USER'
                                   END) AS status
                             FROM ".config('constants.tb_ukurlingkerja')." tu
                             INNER JOIN ".config('constants.tb_organisasi')." tl ON tl.id_lokasi = tu.id_lokasi
                             WHERE tu.status_hapus = 1 ".$subquery."
                             ORDER BY tu.updated_at DESC");

        return Datatables::of(collect($data))->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'tanggal'     => 'required',
          'lokasi'      => 'required',
          'kegiatan'    => 'required',
          'no_notif'    => 'required'
        ]);

        $id_ukur = '';
        if($request->id_ukurlingkerja){
            $id_ukur = $request->id_ukurlingkerja;
        }

        $tanggal  = DateTime::createFromFormat('d/m/Y', $request->tanggal);
        $data = UkurLingkunganKerja::updateOrCreate(
           [ 'id_ukurlingkerja' => $id_ukur ],
           [
             'tanggal'          => $tanggal->format('Y-m-d'),
             'id_lokasi'        => $request->lokasi,
             'kegiatan'         => $request->kegiatan,
             'no_notif'         => $request->no_notif,
             'updated_at'       => date('Y-m-d H:i:s'),
             'status_hapus'     => 1
           ]
        );

        PetugasPLK::where('id_ukurlingkerja', $data->id_ukurlingkerja)->update(['status_hapus' => '0']);

        $user = json_decode($request->user);

        foreach($user as $user){

            PetugasPLK::updateOrCreate(
               [
                 'id_ukurlingkerja'    => $data->id_ukurlingkerja,
                 'username'            => $user->username
               ],
               [
                 'status_hapus'        => 1
               ]
            );
        }

        return response()->json($data);
    }
}
