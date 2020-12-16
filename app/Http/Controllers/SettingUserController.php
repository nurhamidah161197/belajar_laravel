<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UsersModul;
use App\Organisasi;
use DB;
use Datatables;

class SettingUserController extends Controller
{
    public function plk()
    {
        $organisasi   = Organisasi::where('status_hapus', 1)
                                  ->where('modul', 2)
                                  ->get();

        $header_page  = "page_setting";
        $page         = "page_settinguserplk";

        return view('views.SettingUser', [ 'organisasi'    => $organisasi,
                                           'modul'         => 'plk',
                                           'modul_des'     => 'Pengukuran Lingkungan Kerja',
                                           'header_page'   => $header_page,
                                           'page'          => $page
                                         ]);
    }

    public function p3k()
    {
        $organisasi   = Organisasi::where('status_hapus', 1)
                                  ->where('modul', 1)
                                  ->get();

        $header_page  = "page_setting";
        $page         = "page_settinguserp3k";

        return view('views.SettingUser', [ 'organisasi'    => $organisasi,
                                           'modul'         => 'p3k',
                                           'modul_des'     => 'P3K',
                                           'header_page'   => $header_page,
                                           'page'          => $page
                                         ]);
    }

    public function admin()
    {
        $header_page  = "page_setting";
        $page         = "page_settinguseradmin";

        return view('views.SettingUser', [ 'modul'         => 'admin',
                                           'modul_des'     => 'Admin',
                                           'header_page'   => $header_page,
                                           'page'          => $page
                                         ]);
    }

    public function getdata($modul)
    {

        switch ($modul) {
          case 'p3k':
          case 'plk':
            if($modul=='p3k'){
               $mod = 1;
            }
            if($modul=='plk'){
               $mod = 2;
            }
            $user   = DB::select("SELECT u.id,
                                         u.username,
                                         u.name,
                                         u.email,
                                         um.modul,
                                         CASE
                                         WHEN um.level = 1 THEN 'Approval User'
                                         WHEN um.level = 2 THEN 'User'
                                         END level,
                                         tor.lokasi as organisasi
                                  FROM users u
                                  LEFT JOIN users_modul um ON um.username = u.username AND um.status_hapus = 1
                                  LEFT JOIN 0000_tb_organisasi tor ON tor.id_lokasi = um.organisasi
                                  WHERE um.modul = ".$mod."
                                  ORDER BY u.updated_at DESC");
            break;
          default:
            $user   = DB::select("SELECT u.id,
                                         u.username,
                                         u.name,
                                         u.email,
                                         um.modul,
                                         CASE
                                         WHEN u.level_admin = 1 THEN 'Approval Admin'
                                         WHEN u.level_admin = 2 THEN 'Admin'
                                         END level,
                                         '-' as organisasi
                                  FROM users u
                                  LEFT JOIN users_modul um ON um.username = u.username AND um.status_hapus = 1
                                  WHERE u.status_hapus = 1 AND um.modul IS NULL
                                  ORDER BY u.updated_at DESC");
            break;
        }

        return Datatables::of(collect($user))->make(true);
    }

    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
          'username'    => 'required',
          'name'        => 'required',
          'email'       => 'required|between:3,64|email',
          'level'       => 'required',
        ]);

        switch ($request->modul) {
          case 'p3k':
          case 'plk':
            if($request->modul=='p3k'){
               $mod = 1;
            }
            if($request->modul=='plk'){
               $mod = 2;
            }
            User::updateOrCreate(
               [
                 'username'     => $request->username
               ],
               [
                 'name'         => $request->name,
                 'email'        => $request->email,
                 'status_hapus' => 1
               ]
            );

            UsersModul::updateOrCreate(
               [
                 'username'     => $request->username,
                 'modul'        => $mod
               ],
               [
                 'level'        => $request->level,
                 'organisasi'   => $request->organisasi,
                 'status_hapus' => 1
               ]
            );
            break;
          default:
            User::updateOrCreate(
               [
                 'username'     => $request->username
               ],
               [
                 'name'         => $request->name,
                 'email'        => $request->email,
                 'level_admin'  => $request->level,
                 'status_hapus' => 1
               ]
            );

            UsersModul::where('username', $request->username)->update(['status_hapus' => 0]);

            break;
        }


    }

    public function getusername($modul, $id)
    {
        switch ($modul) {
          case 'p3k':
          case 'plk':
            $user   = DB::select("SELECT u.id,
                                         u.username,
                                         u.name,
                                         u.email,
                                         um.level,
                                         um.organisasi
                                  FROM users u
                                  LEFT JOIN users_modul um ON um.username = u.username AND um.status_hapus = 1
                                  WHERE u.username = ".$id);
            break;
          default:
            $user   = DB::select("SELECT u.id,
                                         u.username,
                                         u.name,
                                         u.email,
                                         u.level_admin as level,
                                         '80' as organisasi
                                  FROM users u
                                  WHERE u.username = ".$id);
            break;
        }

        return response()->json(['data' => $user[0]]);

    }

    public function destroy($modul, $id)
    {

        switch ($modul) {
          case 'p3k':
          case 'plk':

            if($modul=='p3k'){
               $mod = 1;
            }
            if($modul=='plk'){
               $mod = 2;
            }
            DB::enableQueryLog();
            UsersModul::where('username', $id)
                      ->where('modul', $mod)
                      ->update(['status_hapus' => '0']);
            User::where('username', $id)->update(['status_hapus' => '0']);
            // dd(DB::getQueryLog());
            break;
          default:

            User::where('username', $id)->update(['status_hapus' => '0']);

            break;
        }
    }
}
