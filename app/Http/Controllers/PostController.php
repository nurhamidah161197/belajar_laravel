<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $users = User::get();
        $this->validate(request(), [
          'title'    =>'required',
          'body'    =>'required',
        ]);
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        foreach($users as $user)
        {
            Mail::to($user->email)->send(new PostSubscribtion($post));
        }
        return redirect('/');
    }

    public function send()
    {

        $data = ['alamat' => 'handikapranajaya@gmail.com', 'nama' => 'Handika Pranajaya'];

        Mail::send('mails.reminder', [ 'data' => $data ], function($mail) use($data) {
            $mail->from('montilan.audit@pupuk-indonesia.com', 'Tim Audit SPI PIHC');
            $mail->subject('SI MTL PT. PUPUK INDONESIA');
            $mail->to($data['alamat'], $data['nama']);
        });

        // return view('mails.reminder', [ 'alamat'  => 'handikapranajaya@gmail.com',
        //                                 'nama'    => 'Handika Pranajaya' ]);
    }
}
