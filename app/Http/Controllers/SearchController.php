<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(){
        foreach (glob("C:/Users/z000044455/Desktop/sample_files/*.xml") as $filename) {
            $file = basename($filename, ".xml"); 
            echo "$file"."\n";
        }
        return view('home', compact('filename'));
    }

}
