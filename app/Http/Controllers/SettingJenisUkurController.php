<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisUkur;
use DB;
use Datatables;
use DateTime;

class SettingJenisUkurController extends Controller
{
    public function index()
    {
        $header_page  = "page_setting";
        $page         = "page_settingjenisukur";

        return view('views.SettingJenisUkur', [
            'header_page'   => $header_page,
            'page'          => $page
        ]);
    }

    public function getdata()
    {
        $jenis = DB::select("SELECT id,
                                    jenis,
                                    satuan,
                                    DATE_FORMAT(updated_at,'%d/%m/%Y') AS tgl_update
                             FROM ".config('constants.tb_jenis_ukur')."
                             WHERE status_hapus = 1
                             ORDER BY updated_at DESC");

        return Datatables::of(collect($jenis))->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'jenis'       => 'required',
          'satuan'      => 'required'
        ]);

        $tanggal  = DateTime::createFromFormat('d/m/Y', $request->tgl_update);
        $id = '';
        if($request->id_jenis){
            $id       = $request->id_jenis;
        }

        JenisUkur::updateOrCreate(
           [ 'id'           => $id ],
           [
             'jenis'        => $request->jenis,
             'satuan'       => $request->satuan,
             'updated_at'   => date('Y-m-d H:i:s')
           ]
        );
    }

    public function getjenis($id)
    {
        $data = JenisUkur::Where('id', $id)->first();
        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {
        JenisUkur::where('id', $id)->update([ 'status_hapus' => 0 ]);
    }
}
