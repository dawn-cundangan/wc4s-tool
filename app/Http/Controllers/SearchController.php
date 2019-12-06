<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;

ini_set('max_execution_time', '500');

class SearchController extends Controller
{
    public function index() {
        $this->checkXMLCond("S_BatesStamp_D");
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

    // Function for getting the parent of the input screen ID.
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
        return array_values(array_unique($finalOutput));
    }
    
    // Function for getting the child of the input screen ID.
    function rootToLeaf(Request $request){
        $filename = $request->rootToLeaf;
        $filename .= ".xml";
        $transitions = array();
        $searchfor = 'Transition_Destination_Window';
        header('Content-Type: text/plain');
        // Check if the file does exist in the source folder.
        if (Storage::disk('fileDisk')->exists($filename)){
            $contents = Storage::disk('fileDisk')->get($filename);
            $pattern = preg_quote($searchfor, '/');
            $pattern = "/^.*$pattern.*\$/m";
            //Find all the screens that matches the given pattern.
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
        return array_values(array_unique($transitions));
    }

    function checkXMLCond($filename){
        $resultfile = fopen("finalResults.txt", "w") or die("Unable to open file!");
        $filename .= ".xml";
        if (Storage::disk('fileDisk')->exists($filename)){
            $contents = Storage::disk('fileDisk')->get($filename);
            $dom = new \DOMDocument;
            $dom->loadXML($contents);
            $books = $dom->getElementsByTagName('Behavior');
            foreach ($books as $book) {
                if($book->getElementsByTagName('Behavior_Type')->item(0)->nodeValue==5){
                    fwrite($resultfile,$book->getElementsByTagName('Transition_Destination_Window')->item(0)->nodeValue);
                    fwrite($resultfile,"\n");
                }
                else if($book->getElementsByTagName('Behavior_Type')->item(0)->nodeValue==6){
                    
                    if(!$book->getElementsByTagName('Transition_Kind')->item(0)){
                        fwrite($resultfile,$book->getElementsByTagName('Transition_Destination_Window')->item(0)->nodeValue);
                        fwrite($resultfile,"\n");
                    }
                    else if($book->getElementsByTagName('Transition_Kind')->item(0)->nodeValue=='open'){
                        fwrite($resultfile,"\nValue:");
                        fwrite($resultfile,$book->getElementsByTagName('Transition_Kind')->item(0)->nodeValue);
                        fwrite($resultfile,$book->getElementsByTagName('Transition_Destination_Window')->item(0)->nodeValue);
                        fwrite($resultfile,"\n");
                    }
                }
            }
        }
        fclose($resultfile);

    }
}