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

    function openFile(Request $request)
    {   
        if($request->ajax())
        {
            $finalTree = array();
            $file = $request->openFile;
            return Response($this->getParent($file));
        }
        
    }

    // Function for retrieving the parent/predecessor of the input screen.
    function getParent($filename){
        $searchfor = '<Transition_Destination_Window>'.$filename;
        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";

        // The following line prevents the browser from parsing this as HTML.
        header('Content-Type: text/plain');
        $mz = array();
        $finalOutput = array();
        $id=0;

        // Go through all the files in the folder as $f
        foreach (Storage::disk('fileDisk')->files() as $f )
        {
            // Retrieve the content of each file $f
            $contents = Storage::disk('fileDisk')->get($f);

            // Find all matches and push to array ($finalOutput) which will be returned.
            if(preg_match_all($pattern, $contents, $matches)){
                array_push($mz,$f);
                $id+=1;
                $txt = substr($f, 0, -4);
                array_push($finalOutput,$txt);
            }
        }
        // If the input screen ID has no parent/predecessor exists. 
        if(sizeof($mz)==0){
            return "No Parent File";
        }
        // If there exists (parent/predecessor).
        else{
            return $finalOutput;
        }
    }
}