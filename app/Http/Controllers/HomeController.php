<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {
        // dd(session()->all());

        $header_page  = "page_home";
        $page         = "";

        return view('views.home', [
            'header_page'   => $header_page,
            'page'          => $page
        ]);
    }
}
