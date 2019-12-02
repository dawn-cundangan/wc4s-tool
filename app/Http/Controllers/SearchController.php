<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

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


    function openFile(Request $request)
    {   
        if($request->ajax())
        {
            // echo "<script>console.log('Debug Objects: " . $request->openFile . "' );</script>";
            // return Response( $request->openFile);
            $finalTree = array();
            $file = $request->openFile;
            $this->getParent($file);

            $filesAsArray = explode("\n",file_get_contents("logs.txt"));

            foreach ($filesAsArray as $aFile)  { 
                if($aFile!=""){
                    $fileName = explode(" => ", $aFile);
                    $fileName = $fileName[1];
                    $this->getParent($fileName);
                    $filesAsArray = explode("\n",file_get_contents("logs.txt"));
                }
            }
            //$this->throughTheFile();
            
        }
        
    }


    function getParent($filename){
        $searchfor = '<Transition_Destination_Window>'.$filename;
        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";

        // the following line prevents the browser from parsing this as HTML.
        header('Content-Type: text/plain');
        $mz = array();
        $id=0;

        // go through all the files in the folder as $f
        foreach (Storage::disk('fileDisk')->files() as $f )
        {
            // retriev the content of each file $f
            $contents = Storage::disk('fileDisk')->get($f);

            if(preg_match_all($pattern, $contents, $matches)){
                array_push($mz,$f);
                $id+=1;
                $txt = $id."/".$filename." => ".substr($f, 0, -4);
                $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
                fwrite($myfile, "\n". $txt);
                fclose($myfile);
            }
        }

        if(sizeof($mz)==0){
            echo "No parent file";
        }
        return;
    }
}