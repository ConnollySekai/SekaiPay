<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    /**
     * Displays advertising page
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return view('advertisement');
    }
}
