<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisasi;
use DB;
use Datatables;

class SettingOrganisasiController extends Controller
{
    public function plk()
    {
        $header_page  = "page_setting";
        $page         = "page_settinglokasiukur";

        return view('views.SettingOrganisasi', [ 'modul'      => 'plk',
                                                 'modul_des'  => 'Pengukuran Lingkungan Kerja',
                                                 'header_page'   => $header_page,
                                                 'page'          => $page
                                               ]);
    }

    public function p3k()
    {
        $header_page  = "page_setting";
        $page         = "page_settinglokasikotak";

        return view('views.SettingOrganisasi', [ 'modul'         => 'p3k',
                                                 'modul_des'     => 'P3K',
                                                 'header_page'   => $header_page,
                                                 'page'          => $page
                                               ]);
    }

    public function getdata($modul)
    {
        switch ($modul) {
          case 'p3k':
            $modul = '1';
            break;
          default:
            $modul = '2';
            break;
        }

        $lokasi     = Organisasi::where('status_hapus', 1)
                               ->where('modul', $modul)
                               ->orderBy('updated_at', 'desc')
                               ->get();

        return Datatables::of($lokasi)->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'lokasi'     => 'required'
        ]);

        $id = '';
        if($request->id_lokasi){
            $id       = $request->id_lokasi;
        }

        switch ($request->modul) {
          case 'p3k':
            $modul = '1';
            break;
          default:
            $modul = '2';
            break;
        }

        Organisasi::updateOrCreate(
           [ 'id_lokasi'     => $id ],
           [
             'lokasi'        => $request->lokasi,
             'modul'         => $modul,
             'updated_at'    => date('Y-m-d H:i:s')
           ]
        );
    }

    public function getorg($id)
    {
        $data = Organisasi::Where('id_lokasi', $id)->first();
        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {
        Organisasi::where('id_lokasi', $id)->update([ 'status_hapus' => 0 ]);
    }
}
