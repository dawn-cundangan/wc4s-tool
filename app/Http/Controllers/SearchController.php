<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
        foreach (glob("D:/00_Project/Source/*.xml") as $filename) {
            $file = basename($filename, ".xml"); 
            echo "$file"."\n";
        }
        return view('home', compact('filename'));
    }
}
