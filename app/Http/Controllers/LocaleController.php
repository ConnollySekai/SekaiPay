<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    /**
     * Outputs laravel's locale for js use
     *
     * @return void
     */
    public function localizeForJs()
    {
        $lang = config('app.locale');
            
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
