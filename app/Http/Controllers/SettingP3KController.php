<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P3K;
use DB;
use DataTables;
use DateTime;

class SettingP3KController extends Controller
{
    public function index()
    {
        $header_page  = "page_setting";
        $page         = "page_settingisikotak";

        return view('views.SettingP3K', [
            'header_page'   => $header_page,
            'page'          => $page
        ]);
    }

    public function getdata()
    {
        $barang     = DB::select(" SELECT id_barang,
                                          barang,
                                          satuan,
                                          DATE_FORMAT(updated_at,'%d/%m/%Y') AS tgl_update
                                   FROM 0000_tb_p3k
                                   WHERE status_hapus = 1
                                   ORDER BY updated_at DESC");

        return DataTables::of(collect($barang))->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'barang'     => 'required'
        ]);

        $id = '';
        if($request->id_barang){
            $id = $request->id_barang;
        }

        P3K::updateOrCreate(
           [ 'id_barang'     => $id ],
           [
             'barang'        => $request->barang,
             'satuan'        => $request->satuan,
             'tgl_update'    => date('Y-m-d H:i:s')
           ]
        );
    }

    public function getbarang($id)
    {
        $data = P3K::Where('id_barang', $id)->first();
        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {
        P3K::where('id_barang', $id)->update([ 'status_hapus' => 0 ]);
    }
}
