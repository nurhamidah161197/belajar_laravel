<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InspeksiP3K;
use App\Organisasi;
use App\User;
use App\UsersModul;
use DB;
use DataTables;
use DateTime;
use Session;

class listInspeksiController extends Controller
{
    public function index()
    {
        $header_page  = "page_laporan";
        $page         = "page_laporaninspeksistok";

        $lokasi       = Organisasi::where('status_hapus', 1)
                                  ->where('modul', 1)
                                  ->get();

        $user         = DB::select("SELECT um.*, u.name
                                    FROM users_modul um
                                    LEFT JOIN users u ON u.username = um.username
                                    WHERE um.modul = 1");

        return view('views.listInspeksiP3K', [
            'lokasi'        => $lokasi,
            'user'          => $user,
            'header_page'   => $header_page,
            'page'          => $page
        ]);
    }

    public function getdata($bulan)
    {
        $period   = explode('.', $bulan);

        $subquery = "AND ti.periode = '".$period[1].'-'.$period[0]."' AND ti.status NOT IN (0,1) ";
        if(in_array(Session::get('level[1]'), [1,2])){
            $subquery = "AND ti.id_lokasi = '".Session::get('organisasi[1]')."'";
        }

        DB::enableQueryLog();
        $data   = DB::select("SELECT ti.id,
                                     DATE_FORMAT(ti.created_at, '%d/%m/%Y') AS tanggal,
                                     tl.lokasi AS desc_lokasi,
                                     periode AS periode,
                                     ti.representatif,
                                     ti.status
                              FROM 2000_tb_inspeksip3k ti
                              LEFT JOIN 0000_tb_organisasi tl ON tl.id_lokasi = ti.id_lokasi
                              WHERE ti.status_hapus = 1 ".$subquery."
                              ORDER BY ti.id DESC");

        // dd(DB::getQueryLog());

        return DataTables::of(collect($data))->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'lokasi'        => 'required',
          'periode'       => 'required'
        ]);

        $periode  = DateTime::createFromFormat('m/Y', $request->periode);

        $data = InspeksiP3K::updateOrCreate(
           [
             'periode'          => $periode->format('Y-m'),
             'id_lokasi'        => $request->lokasi
           ],
           [
             'representatif'    => $request->representatif,
             'status_hapus'     => 1,
           ]
        );

        return response()->json(['id' => $data->id]);
    }
}
