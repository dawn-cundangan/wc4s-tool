<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;
ini_set('max_execution_time', '500');
class SearchController extends Controller
{
    public function index() {
        return view('home');
    }

    public function viewTransition(Request $request) {
        $searchfor = 'Transition_Destination_Window';
        // the following line prevents the browser from parsing this as HTML
        header('Content-Type: text/plain');
        // get the file contents, assuming the file to be readable (and exist)
        $contents = Storage::disk('fileDisk')->get('S_Zoom_T.xml');
        // escape special characters in the query
        $pattern = preg_quote($searchfor, '/');
        // finalise the regular expression, matching the whole line
        $pattern = "/^.*$pattern.*\$/m";
        // search, and store all matching occurences in $matches
        if (preg_match_all($pattern, $contents, $matches)) {
            echo "Found matches:\n";
            echo implode("\n", $matches[0]);
        } else {
            echo "No matches found";
        }
    }
    
    function search (Request $request) {   
        // $filesInFolder = Storage::disk('confidential_files')->getDriver()->getAdapter()->applyPathPrefix('*.xml');
        if ($request->ajax()) {
            $output="";
            $number = 1;
            foreach (glob("C:/Users/z000044455/Desktop/Source/*.xml") as $filename) {
                $pattern= '/(?i)('.$request->search.')/';
                if (preg_match($pattern, basename($filename))) {
                    $output.='<tr>'.'<td>'.$number.'</td><td class="filename">'.basename($filename, ".xml").'</td>'.'</tr>';
                    $number = $number+1;
                }
            }
            if ($output!="") {
                return Response($output);
            } else {
                return Response("none");
            }
        }
    }


    function openFile(Request $request) {   
        $finalTree = array();
        $filename = $request->openFile;
        $searchfor = '<Transition_Destination_Window>'.$filename;

        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        // the following line prevents the browser from parsing this as HTML.
        header('Content-Type: text/plain');

        $fileArray = array();
        $finalOutput = array();
        $id = 0;

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
        return $finalOutput;

        if(sizeof($fileArray)==0){
            array_push($finalOutput, "No parent");
        }
        
        return $finalOutput;
    }
}