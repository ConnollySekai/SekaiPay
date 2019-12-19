<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Sets locale session
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        session(['locale' =>  $locale]);
        
        return response()->json([
            'success' => true
        ],200);
    }
    
    /**
     * Outputs laravel's locale for js use
     *
     * @return void
     */
    public function localizeForJs()
    {
        $lang = config('app.locale');

        //check if lang folder exist then set to english if not
        if (!is_dir(resource_path('lang/'.$lang))) {
            $lang = 'en';
        }
            
        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];
        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }
        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        
        exit();
    }
}
