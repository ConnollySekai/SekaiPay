<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['localizebybrowser'])->group(function(){ 

    Route::get('/','HomeController@index')->name('home.index');

    Route::get('/invoice/{invoice}','InvoiceController@show')->name('invoice.show');

    Route::get('/invoice/get/data', 'InvoiceController@getData')->name('invoice.getData');

    Route::post('/invoice/store','InvoiceController@store')->name('invoice.store');

    Route::get('/invoice/download/pdf/{invoice}','InvoiceController@downloadPDF')->name('invoice.downloadPDF');

    Route::get('/js/lang.js','LocaleController@localizeForJs')->name('locale.localizeForJs');
});

Route::get('/setLocale','LocaleController@setLocale')->name('locale.setLocale');
