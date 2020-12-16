<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NAB;
use App\JenisUkur;
use App\NilaiNAB;
use DB;
use DataTables;
use DateTime;

class SettingNilaiNABController extends Controller
{
    public function index($id)
    {
        $header_page  = "page_setting";
        $page         = "page_settingnab";

        $nab          = NAB::where('id', $id)->first();

        return view('views.SettingNilaiNAB', [  'id'            => $id,
                                                'no_surat'      => $nab->no_surat,
                                                'header_page'   => $header_page,
                                                'page'          => $page
                                             ]);
    }

    public function getdata($id)
    {
        $nab = DB::select("SELECT tnn.*, tj.jenis, tj.satuan, tn.no_surat
                           FROM 0000_tb_nilainab tnn
                           INNER JOIN 0000_tb_jenisukur tj ON tj.id = tnn.id_jenis
                           INNER JOIN 0000_tb_nab tn ON tn.id = tnn.id_surat
                           WHERE tnn.status_hapus = 1 AND tnn.id_surat = '".$id."'
                           ORDER BY tnn.updated_at DESC");

        return DataTables::of(collect($nab))->make(true);
    }

    public function store(Request $request)
    {

        if($request->id_nab){
            $id       = $request->id_nab;

            NilaiNAB::where('id', $id)->update([
              'nab'          => $request->hasil,
              'updated_at'   => date('Y-m-d H:i:s')
            ]);

        }else{

            $this->validate($request, [
              'jenisukur'     => 'required',
              'hasil'         => 'required',
              'id_surat'      => 'required'
            ]);

            NilaiNAB::create(
               [
                 'id_surat'     => $request->id_surat,
                 'id_jenis'     => $request->jenisukur,
                 'nab'          => $request->hasil,
                 'updated_at'   => date('Y-m-d H:i:s')
               ]
            );
        }
    }

    public function getnab($id)
    {
        $data = DB::select("SELECT tn.*, tj.jenis, tj.satuan
                            FROM 0000_tb_nilainab tn
                            INNER JOIN 0000_tb_jenisukur tj ON tj.id = tn.id_jenis
                            WHERE tn.id = '".$id."'");

        return response()->json(['data' => $data[0]]);
    }

    public function getjenisukur($id)
    {
        $data = DB::select("SELECT tj.*, tn.id AS id_nilai
                            FROM 0000_tb_jenisukur tj
                            LEFT JOIN 0000_tb_nilainab tn ON tn.id_jenis = tj.id AND tn.id_surat = 1 AND tn.status_hapus = 1
                            WHERE tj.status_hapus = 1 AND tn.id IS NULL");

        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {
        NilaiNAB::where('id', $id)->update([ 'status_hapus' => 0 ]);
    }
}
