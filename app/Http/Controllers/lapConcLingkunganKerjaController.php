<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Http\Request;
use App\UkurLingkunganKerja;
use App\Organisasi;
use App\KeteranganLingkuganKerja;
use App\PetugasPLK;
use App\User;
use DB;

class lapConcLingkunganKerjaController extends Controller
{
    public function index($id)
    {
        $header_page  = "page_laporan";
        $page         = "page_laporanpengukuranlingkerja";

        $master       = DB::select("SELECT tu.id_ukurlingkerja,
                                           tu.tanggal as tgl,
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

        // dd($master);
        DB::enableQueryLog();
        $data         = DB::select("SELECT tj.id, tj.jenis, tn.nab, tj.satuan
                                    FROM 1001_tb_lokukurlingkerja tl
                                    LEFT JOIN 1002_tb_hasilukurlingkerja th ON th.id_lokukurlingkerja = tl.id_lokukurlingkerja AND th.status_hapus = 1
                                    INNER JOIN 0000_tb_jenisukur tj ON tj.id = th.id_jenis AND th.status_hapus = 1
                                    INNER JOIN 0000_tb_nilainab tn ON tn.id_jenis = th.id_jenis AND tn.status_hapus = 1
                                    WHERE tl.id_ukurlingkerja =  '".$id."'
                                    GROUP BY tj.id
                                    ORDER BY tj.id");
        // dd(DB::getQueryLog());
        // dd($data);

        // DB::enableQueryLog();

        $nab          = DB::select("SELECT *
                                    FROM 0000_tb_nab
                                    WHERE tanggal = ( SELECT MAX(tanggal) FROM 0000_tb_nab WHERE tanggal <= '".$master[0]->tgl."' AND status_hapus = 1)");
        // dd(DB::getQueryLog());

        $hasil        = DB::select("SELECT th.*
                                    FROM 1001_tb_lokukurlingkerja tl
                                    LEFT JOIN 1002_tb_hasilukurlingkerja th ON th.id_lokukurlingkerja = tl.id_lokukurlingkerja
                                    WHERE tl.id_ukurlingkerja = '".$id."' AND th.status_hapus = 1");

        $lokasi       = Organisasi::where('status_hapus', 1)
                                  ->where('modul', 2)
                                  ->get();

        $has = array();
        foreach($hasil as $hasil_){

            if(!isset($has[$hasil_->id_jenis])){
                $has[$hasil_->id_jenis] = array();
            }
            array_push($has[$hasil_->id_jenis], $hasil_->hasil);
        }

        $keterangan   = KeteranganLingkuganKerja::where('id_ukurlingkerja', $id)->get();

        $ket = array();
        foreach($keterangan as $keterangan){
            $ket[$keterangan->id_jenis]['id_keterangan']   = $keterangan->id_keterangan;
            $ket[$keterangan->id_jenis]['keterangan']      = $keterangan->keterangan;
        }

        DB::enableQueryLog();

        $petugas      = DB::select("SELECT tp.*, u.name
                                    FROM 1004_tb_petugas tp
                                    INNER JOIN users u ON u.username = tp.username AND u.status_hapus = 1
                                    WHERE tp.id_ukurlingkerja = '".$id."' AND tp.status_hapus = 1");

        // dd(DB::getQueryLog());

        $user         = DB::select("SELECT *
                                    FROM  users
                                    WHERE status_hapus = 1 AND level_admin IN (1,2)");

        return view('views.lapConcLingkunganKerja', [ 'master'      => $master[0],
                                                      'nab'         => $nab[0],
                                                      'data'        => $data,
                                                      'hasil'       => $has,
                                                      'keterangan'  => $ket,
                                                      'lokasi'      => $lokasi,
                                                      'petugas'     => $petugas,
                                                      'user'        => $user,
                                                      'header_page' => $header_page,
                                                      'page'        => $page
                                                    ]);
    }

    public function storekesimpulan(Request $request)
    {
        $data               = UkurLingkunganKerja::find($request->id);
        $data->kesimpulan   = $request->kesimpulan;
        $data->rekomendasi  = $request->rekomendasi;
        $data->save();
    }

    public function storeketerangan(Request $request)
    {
        if(!empty($request->id_keterangan)){
            $id       = $request->id_keterangan;
        }else{
            $id       = kdauto("KET", '1003_tb_keterangan');
        }

        KeteranganLingkuganKerja::updateOrCreate(
           [
             'id_keterangan'        => $id
           ],
           [
             'id_ukurlingkerja'     => $request->id_ukurlingkerja,
             'id_jenis'             => $request->id_jenis,
             'keterangan'           => $request->keterangan
           ]
        );
    }

    public function storetindaklanjut(Request $request)
    {
        $data               = UkurLingkunganKerja::find($request->id);
        $data->tindaklanjut = $request->tindaklanjut;
        $data->save();
    }

    public function getpetugas($id)
    {
        DB::enableQueryLog();
        $data = DB::select("SELECT tp.*, u.name
                                   FROM 1004_tb_petugas tp
                                   INNER JOIN users u ON u.username = tp.username
                                   WHERE tp.id_ukurlingkerja = '".$id."' AND tp.status_hapus = 1");

        // dd(DB::getQueryLog());

        return response()->json(['data' => $data]);
    }

    public function storestatus($id, $status)
    {
        UkurLingkunganKerja::where('id_ukurlingkerja', $id)->update(['status' => $status]);

        if($status!=4){
            $this->mail($id, $status);
        }
    }

    public function mail($id, $status)
    {

        $master   = DB::select("select tu.*, tor.lokasi
                                from 1000_tb_ukurlingkerja tu
                                left join 0000_tb_organisasi tor on tor.id_lokasi = tu.id_lokasi
                                where tu.id_ukurlingkerja = 1");

        // dd($master);
        DB::enableQueryLog();
        if($status==2){
            $user = "ADMIN APPROVAL";

            $data = DB::select("SELECT u.username, u.name, u.email
                                FROM users u
                                WHERE u.status_hapus = 1 AND u.level_admin = 1");

        }else{
            $user = "USER APPROVAL";

            $data = DB::select("SELECT um.username, u.name, u.email
                                FROM users_modul um
                                LEFT JOIN users u ON u.username = um.username
                                WHERE um.status_hapus = 1 AND um.modul = 2 AND um.organisasi = '".$master[0]->id_lokasi."'");

        }

        // dd(DB::getQueryLog());

        $subject  = "LAPORAN PENGUKURAN LINGKUNGAN KERJA";
        $name     = 'SI HIPERKES';

        $message  = "Kepada Yth, <br>
                     <b>".$user."</b> <br><br>
                     Anda mendapatkan Laporan Pengukuran Lingkungan Kerja. <br><br>

                     Tanggal      : ".date('d/m/Y', strtotime($master[0]->tanggal))." <br>
                     Lokasi Ukur  : ".$master[0]->lokasi." <br><br>

                     Silahkan Login, untuk melihat isi laporan tersebut. <br>
                     http://hiperkes.pusri.co.id.";



        $mail = new PHPMailer(true);                              // Passing true enables exceptions
        try {

            // Pengaturan Server
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'webmail.pusri.co.id';                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'automailhp@pusri.co.id';                 // SMTP username
            $mail->Password = 'JalanMelurNo7';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Siapa yang mengirim email
            $mail->setFrom("automailhp@pusri.co.id", "SI HIPERKES");

            // Siapa yang akan menerima email
            // for($i=0;$i<count($email);$i++){
            //
            // }
            foreach ($data as $data) {
                $mail->addAddress($data->email, "Tim SI Hiperkes");
            }
            // $mail->addAddress($emailAddress, $name);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();

        } catch (Exception $e) {
            echo 'Message could not be sent.<br>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }


}
