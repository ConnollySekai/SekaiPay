<?php

namespace App\Services;

use App;

class Localization
{
    
    /**
     * Localize based on user selection. By Default localize by browser language
     *
     * @return void
     */
    public static function byBrowser()
    {
        $locale = App::getLocale();

        $browser_locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        
        if(session('locale')) {
            $locale = session('locale');
        } else {
        
            $locale = $browser_locale;    
        }
        App::setLocale($locale);
    }
}