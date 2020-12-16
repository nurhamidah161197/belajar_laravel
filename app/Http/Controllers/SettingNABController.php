<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NAB;
use DB;
use Datatables;
use DateTime;

class SettingNABController extends Controller
{
    public function index()
    {
        $header_page  = "page_setting";
        $page         = "page_settingnab";

        return view('views.SettingNAB',[
          'header_page'   => $header_page,
          'page'          => $page
        ]);
    }

    public function getdata()
    {
        $nab   = DB::select("SELECT id,
                                    no_surat,
                                    DATE_FORMAT(tanggal,'%d/%m/%Y') AS tanggal
                             FROM ".config('constants.tb_nab')."
                             WHERE status_hapus = 1
                             ORDER BY updated_at DESC");

        return Datatables::of(collect($nab))->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'no_surat'     => 'required',
            'TanggalSurat' => 'required'
        ]);

        $id = '';
        if($request->id_surat){
            $id       = $request->id_surat;
        }

        $tanggal  = DateTime::createFromFormat('d/m/Y', $request->TanggalSurat);
        NAB::updateOrCreate(
           [ 'id'     => $id ],
           [
             'no_surat'     => $request->no_surat,
             'tanggal'      => $tanggal->format('Y-m-d'),
             'updated_at'   => date('Y-m-d H:i:s')
           ]
        );
    }

    public function getnab($id)
    {
        $data = NAB::Where('id', $id)->first();
        return response()->json(['data' => $data]);

    }

    public function destroy($id)
    {
        NAB::where('id', $id)->update([ 'status_hapus' => 0 ]);
    }
}
