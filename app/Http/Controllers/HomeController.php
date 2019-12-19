<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Displays Homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
