<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class SettingPasswordController extends Controller
{
    public function index()
    {
        return view('views.SettingPassword');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'username'            => 'required',
          'old_password'        => 'required',
          'new_password1'       => 'required',
          'new_password2'       => 'required'
        ]);

        $user = User::where('username', $request->username)->first();
        if ((password_verify($request->old_password, $user->password)) and (trim($request->new_password1)==trim($request->new_password2))) {

            $data = User::find($user->id);
            $data->password = bcrypt($request->new_password1);
            $data->save();

        }else{

            die(header("HTTP/1.0 404 Not Found"));

        }





        // DB::enableQueryLog();
        //
        // $collection = User::where('username', $request->username)->where('password', bcrypt($request->old_password))->get();
        //
        // dd(DB::getQueryLog());
        // // dd($collection);
        //
        // if($request->new_password1==$request->new_password2){
        //     $collection->update(['password' => $request->new_password1]);
        // }

    }
}
