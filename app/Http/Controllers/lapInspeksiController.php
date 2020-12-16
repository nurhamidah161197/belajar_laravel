<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\InspeksiP3K;
use App\Organisasi;
use App\User;
use App\UsersModul;
use App\HasilInspeksiP3K;
use App\P3K;
use DB;

class lapInspeksiController extends Controller
{
    public function index($id)
    {
        $header_page  = "page_laporan";
        $page         = "page_laporaninspeksistok";

        $master       = DB::select("SELECT ti.*, tor.lokasi, u.name, DATE_FORMAT(ti.created_at, '%d.%m.%Y') AS tanggal
                                    FROM 2000_tb_inspeksip3k ti
                                    LEFT JOIN 0000_tb_organisasi tor ON tor.id_lokasi = ti.id_lokasi
                                    LEFT JOIN users u ON u.username = ti.representatif
                                    WHERE ti.id = ".$id);

        // dd($master);

        $lokasi       = organisasi::where('status_hapus', 1)
                                  ->where('modul', 1)
                                  ->get();

        $user         = DB::select("SELECT um.*, u.name
                                    FROM users_modul um
                                    LEFT JOIN users u ON u.username = um.username
                                    WHERE um.modul = 1");

        // dd($user);


        $p3k          = P3K::where('status_hapus', 1)
                           ->where('created_at', '>=', $master[0]->tanggal)
                           ->get();

        $result       =  DB::select("SELECT th.*
                                     FROM 2001_tb_hasilinspeksip3k th
                                     WHERE th.id_inspeksip3k = '".$id."' AND th.status_hapus = 1");
        // dd($result);

        $data = array();
        foreach($result as $result)
        {
           $data[$result->id_barang]['id_hasilinspeksip3k']  = $result->id_hasilinspeksip3k;
           $data[$result->id_barang]['id_inspeksip3k']       = $result->id_inspeksip3k;
           $data[$result->id_barang]['jumlah']               = $result->jumlah;
           $data[$result->id_barang]['kondisi']              = $result->kondisi;
           $data[$result->id_barang]['keterangan']           = $result->keterangan;
        }

        $old_data = array();

        DB::enableQueryLog();

        $old_result   = DB::select("SELECT th.*
                                    FROM 2000_tb_inspeksip3k ti
                                    RIGHT JOIN 2001_tb_hasilinspeksip3k th ON ti.id = th.id_inspeksip3k
                                    WHERE ti.periode = (SELECT MAX(ti2.periode)
                                                		    FROM 2000_tb_inspeksip3k ti2
                                                		    INNER JOIN 2001_tb_hasilinspeksip3k th2 ON th2.id_inspeksip3k = ti2.id AND th2.status_hapus = 1
                                                		    WHERE ti2.id_lokasi = '".$master[0]->id_lokasi."' AND ti2.status_hapus = 1 AND ti2.periode <= '".date('Y-m', strtotime($master[0]->periode))."')
                                    AND ti.id_lokasi = '".$master[0]->id_lokasi."' AND ti.status_hapus=1");

        // dd(DB::getQueryLog());
        // dd($old_result);
        foreach($old_result as $result)
        {
           $old_data[$result->id_barang]['id_hasilinspeksip3k']  = $result->id_hasilinspeksip3k;
           $old_data[$result->id_barang]['id_inspeksip3k']       = $result->id_inspeksip3k;
           $old_data[$result->id_barang]['jumlah']               = $result->jumlah;
           $old_data[$result->id_barang]['kondisi']              = $result->kondisi;
           $old_data[$result->id_barang]['keterangan']           = $result->keterangan;
        }

        return view('views.lapInspeksiP3K', [ 'master'      => $master[0],
                                              'lokasi'      => $lokasi,
                                              'user'        => $user,
                                              'p3k'         => $p3k,
                                              'data'        => $data,
                                              'old_data'    => $old_data,
                                              'header_page' => $header_page,
                                              'page'        => $page
                                            ]);
    }

    public function storehasil(Request $request)
    {
        // dd($request);
        HasilInspeksiP3K::where('id_inspeksip3k', $request->id_inspeksip3k)->update(['status_hapus' => '0']);

        $data = json_decode($request->data);

        foreach($data as $data){

            if(!empty($data->id_hasilinspeksip3k)){
                $id       = $data->id_hasilinspeksip3k;
            }else{
                $id       = kdauto("HS", '2001_tb_hasilinspeksip3k');
            }

            HasilInspeksiP3K::updateOrCreate(
               [
                 'id_hasilinspeksip3k'         => $id,
               ],
               [
                 'id_inspeksip3k'              => $request->id_inspeksip3k,
                 'id_barang'                   => $data->id_barang,
                 'jumlah'                      => $data->jumlah,
                 'kondisi'                     => $data->kondisi,
                 'keterangan'                  => $data->keterangan,
                 'status_hapus'                => 1
               ]
            );
        }
    }

    public function storestatus($id, $status)
    {
        InspeksiP3K::where('id', $id)->update(['status' => $status]);

        if($status == 3){
            $this->mailtoadmin($id);
        }
    }

    public function mailtoadmin($id)
    {
        $master       = DB::select("SELECT ti.*, tor.lokasi, u.name, DATE_FORMAT(ti.created_at, '%d/%m/%Y') AS tanggal
                                    FROM 2000_tb_inspeksip3k ti
                                    LEFT JOIN 0000_tb_organisasi tor ON tor.id_lokasi = ti.id_lokasi
                                    LEFT JOIN users u ON u.username = ti.representatif
                                    WHERE ti.id = ".$id);

        $subject  = "LAPORAN STOK KOTAK P3K";
        $name     = 'SI HIPERKES';

        $message  = "Kepada Yth, <br>
                     <b>ADMIN</b> <br><br>
                     Anda mendapatkan Laporan Inspeksi Kotak P3K. <br><br>

                     Tanggal     : ".$master[0]->tanggal." <br>
                     Unit Kerja  : ".$master[0]->lokasi." <br><br>

                     Silahkan Login, untuk melihat isi laporan tersebut. <br>
                     http://hiperkes.pusri.co.id.";

        $data     = User::whereIn('level_admin', [1, 2])
                        ->where('status_hapus', 1)
                        ->select('email')
                        ->get();

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
