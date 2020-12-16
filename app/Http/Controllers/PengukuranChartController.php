<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisUkur;
use App\Organisasi;
use DB;

class PengukuranChartController extends Controller
{
    public function index($year, $jenis, $lokasi)
    {
        $header_page  = "page_laporan";
        $page         = "page_laporanpengukuranchart";

        $jenis_ukur   = JenisUkur::where('status_hapus', 1)->get();

        $lokasi_ukur  = Organisasi::where('status_hapus', 1)
                                  ->where('modul', 2)
                                  ->get();

        $jenis_desc   = JenisUkur::where('status_hapus', 1)
                                 ->where('id', $jenis)
                                 ->first();

        $lok = str_replace(".", "','", $lokasi);
        $data         = DB::select("SELECT *
                                    FROM ".config('constants.tb_organisasi')."
                                    WHERE id_lokasi IN ('".$lok."')");

        return view('views.PengukuranChart', [ 'data'         => $data,
                                               'year'         => $year,
                                               'jenis'        => $jenis,
                                               'lokasi'       => $lokasi,
                                               'jenis_ukur'   => $jenis_ukur,
                                               'lokasi_ukur'  => $lokasi_ukur,
                                               'jenis_desc'   => $jenis_desc,
                                               'header_page'   => $header_page,
                                               'page'          => $page
                                             ]);
    }

    public function getdata($year, $jenis, $lokasi)
    {
        $res_fix    = array();
        $lok = explode('.', $lokasi);
        // dd(count($lok));
        $temp = array();
        for($i=0;$i<count($lok);$i++){

            // print_r($lok);
            $graph = array();
            $collect = DB::select(" SELECT tu.id_lokasi, DATE_FORMAT(tu.tanggal, '%m') AS bln, DATE_FORMAT(tu.tanggal, '%M') AS bulan, tt.titik_ukur, tj.jenis, tj.satuan, th.hasil
                                    FROM ".config('constants.tb_ukurlingkerja')." tu
                                    LEFT JOIN ".config('constants.tb_lokukurlingkerja')." tl ON tl.id_ukurlingkerja = tu.id_ukurlingkerja AND tl.status_hapus = 1
                                    INNER JOIN ".config('constants.tb_titikukur')." tt ON tt.id_titikukur = tl.id_titikukur
                                    LEFT JOIN ".config('constants.tb_hasukurlingkerja')." th ON th.id_lokukurlingkerja = tl.id_lokukurlingkerja AND th.status_hapus = 1 AND th.id_jenis = '".$jenis."'
                                    INNER JOIN ".config('constants.tb_jenis_ukur')." tj ON tj.id = th.id_jenis
                                    WHERE tu.status_hapus = 1 AND DATE_FORMAT(tu.tanggal, '%Y') = '".$year."' AND tu.id_lokasi = '".$lok[$i]."'
                                    ORDER BY bln ASC, tl.id_titikukur");
            //

            if(count($collect)!=""){

                $value   = array();
                $titikukur = array();
                foreach ($collect as $collect) {
                    $dt  = array();
                    $dt['periode']            = $collect->bulan;
                    $dt[$collect->titik_ukur]   = $collect->hasil;
                    array_push($value, $dt);
                    array_push($titikukur, $collect->titik_ukur);
                }

                $satuan   = $collect->satuan;
                $id_lokasi = $collect->id_lokasi;

                $titik    = array_unique($titikukur);

                $periode  = $value[0]['periode'];
                $result   = array();
                $data     = array();
                for($j=0;$j<count($value);$j++){
                    if($value[$j]['periode'] == $periode){
                        $result = array_merge($result, $value[$j]);
                    }else{
                        array_push($data, $result);
                        $result = array();
                        $result = array_merge($result, $value[$j]);
                        $periode = $value[$j]['periode'];
                    }
                }
                array_push($data, $result);

                $list_graph = array();
                for($j=0;$j<count($titikukur);$j++){

                    if(isset($titik[$j])){
                        $list_graph = [  'balloonText'     => $titik[$j].": [[value]] ".$satuan,
                                         'fillAlphas'      => 0.8,
                                         'id'              => "AmGraph-".($j+1),
                                         'lineAlpha'       => 0.2,
                                         'title'           => $titik[$j],
                                         'type'            => "column",
                                         'valueField'      => $titik[$j],
                                         'labelText'       => "[[value]] "
                                       ];
                        array_push($graph, $list_graph);
                    }
                }
            }

            $res_array  = array();
            $res_array  = [ 'data'      => $data,
                            'graphx'    => $graph,
                            'id_lokasi' => $id_lokasi
                          ];

            array_push($res_fix, $res_array);
        }

        // exit;
        // dd($temp);

        return response()->json($res_fix);
    }
}
