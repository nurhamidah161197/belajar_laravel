<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\User;

class BroadcastEmailP3KController extends Controller
{
    public function index(){

        $header_page  = "page_laporan";
        $page         = "page_laporanbroadcastp3k";

        $user         = User::where('status_hapus', 1)
                            ->where('modul', 1)
                            ->get();

        return view('views.BroadcastEmailP3K', [
            'user'          => $user,
            'header_page'   => $header_page,
            'page'          => $page
        ]);
    }

    function sendMail(Request $request){

        // dd($request);

        $email = json_decode($request->email);

        $subject = $request->subject;
        $name = 'SI HIPERKES';
        // $emailAddress = $request->input('email');
        $message = $request->body;

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {

            // Pengaturan Server
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'webmail.pusri.co.id';                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'automailhp@pusri.co.id';                 // SMTP username
            $mail->Password = 'JalanMelurNo7';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
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
            foreach ($email as $email) {
                $mail->addAddress($email->email, $email->name);
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
