<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;

ini_set('max_execution_time', '500');

class SearchController extends Controller
{
    public function index() {
        //$this->rootToLeaf('S_Zoom_T');
        return view('home');
    }
    
    // Function for searching the input screen ID from the source files.
    function search(Request $request) {   
        if ($request->ajax()) {
            $output="";
            $number = 1;

            // Will go through all the files inside the source folder.
            foreach (glob("C:/Users/z000044455/Desktop/Source/*.xml") as $filename) {
                $pattern= '/(?i)('.$request->search.')/';
                // If found, display it in tabular form.
                if (preg_match($pattern, basename($filename))) {
                    $output.='<tr>'.'<td>'.$number.'</td><td class="filename">'.basename($filename, ".xml").'</td>'.'</tr>';
                    $number = $number+1;
                }
            }
            // If the input screen ID exists.
            if ($output!="") {
                return Response($output);
            // If the input screen ID does not exist.
            } else {
                return Response("none");
            }
        }
    }

    function leafToRoot(Request $request) {   
        $filename = $request->leafToRoot;
        $searchfor = '<Transition_Destination_Window>'.$filename;

        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        // the following line prevents the browser from parsing this as HTML.
        header('Content-Type: text/plain');

        $fileArray = array();
        $finalOutput = array();
        $id = 0;
        $filename .= ".xml";
        if(Storage::disk('fileDisk')->exists($filename)){
            // go through all the files in the folder as $file
            foreach (Storage::disk('fileDisk')->files() as $file) {
                // retrieve the content of each file $file
                $contents = Storage::disk('fileDisk')->get($file);

                if (preg_match_all($pattern, $contents, $matches)){
                    array_push($fileArray, $file);
                    $id += 1;
                    $txt = substr($file, 0, -4);
                    array_push($finalOutput, $txt);
                }
            }
        } else {
            array_push($finalOutput, "File doesn't exist.");
        }
        return $finalOutput;
    }

    function rootToLeaf(Request $request){
        $filename = $request->rootToLeaf;
        $filename .= ".xml";
        $transitions = array();
        $searchfor = 'Transition_Destination_Window';
        header('Content-Type: text/plain');
        if (Storage::disk('fileDisk')->exists($filename)){
            $contents = Storage::disk('fileDisk')->get($filename);
            $pattern = preg_quote($searchfor, '/');
            $pattern = "/^.*$pattern.*\$/m";
            if(preg_match_all($pattern, $contents, $matches)){
                foreach($matches[0] as $filename){
                    $str1 = (explode('>', $filename,2));
                    $str2 = (explode('<', $str1[1],2));
                    array_push($transitions, $str2[0]);
                }
            }
        } else {
            array_push($transitions, "File doesn't exist.");
        }
        return $transitions;
    }
}