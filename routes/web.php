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

<<<<<<< HEAD
Route::get("/","SearchController@index");
Route::get('/search','SearchController@search');
Route::get('/openFile','SearchController@openFile');
=======
Route::get('/', function () {
    foreach (glob("C:/Users/z000044455/Desktop/sample_files/*.xml") as $filename) {
        $files[] = basename($filename, ".xml"); 
    }
    return view('home', compact('files'));
});

Route::get('/search', 'SearchController@search');
>>>>>>> search transition in a file
