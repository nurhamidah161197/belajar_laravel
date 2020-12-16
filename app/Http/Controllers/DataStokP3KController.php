<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P3K;
use App\DataStokP3K;
use DB;

class DataStokP3KController extends Controller
{
    public function index()
    {
        $header_page  = "page_laporan";
        $page         = "page_laporanstok";

        $p3k          = P3K::where('status_hapus', 1)->get();

        return view('views.DataStokP3K', [
            'p3k'           => $p3k,
            'header_page'   => $header_page,
            'page'          => $page
        ]);
    }

    public function getalldata($date){

        $curdate = date("Y-m-d", strtotime("+1 day", strtotime($date)));

        $data = DB::select("SELECT 	tp.id_barang AS id_barang,
                                  	tp.barang,
                                  	tp.satuan,
                                  	td.id AS id_stok,
                                  	td.stok,
                                  	td.keterangan,
                                  	DATE_FORMAT(td.tgl_update,'%d.%m.%Y') AS tgl_update
                            FROM 0000_tb_p3k tp
                            LEFT JOIN 2002_tb_datastokp3k td ON td.id_barang = tp.id_barang AND td.tgl_update = (SELECT MAX(tgl_update)
                            											     FROM 2002_tb_datastokp3k
                            											     WHERE tgl_update < '".$curdate."' AND id_barang = td.id_barang)
                            WHERE tp.status_hapus = 1 AND tp.created_at < '".$curdate."'
                            ORDER BY tp.id_barang ASC");

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        DataStokP3K::updateOrCreate(
           [
             'id_barang'          => $request->id_barang,
             'tgl_update'         => date('Y-m-d',strtotime($request->tanggal_stok))
           ],
           [
             'stok'               => $request->stok,
             'keterangan'         => $request->keterangan,
           ]
        );
    }

}
