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

        $browser_locale = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';

        // Check if browser locale is not in lang folder. This is for locale variation like es-AR etc
        if (!is_dir(resource_path('lang/'.$browser_locale))) {
            
            // if not get the root locale
            $browser_locale = substr($browser_locale, 0, 2);

            if (!is_dir(resource_path('lang/'.$browser_locale))) {
                $browser_locale = 'en';
            }
        }
        
        if(session('locale')) {
            $locale = session('locale');
        } else {
        
            $locale = $browser_locale;    
        }
        App::setLocale($locale);
    }
}