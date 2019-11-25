<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function viewTransition(Request $request)
    {
                              
        $searchfor = 'Transition_Destination_Window';

        // the following line prevents the browser from parsing this as HTML.
        header('Content-Type: text/plain');

        // get the file contents, assuming the file to be readable (and exist)
        $contents = Storage::disk('fileDisk')->get('S_Zoom_T.xml');
        // escape special characters in the query
        $pattern = preg_quote($searchfor, '/');
        // finalise the regular expression, matching the whole line
        $pattern = "/^.*$pattern.*\$/m";
        // search, and store all matching occurences in $matches
        if(preg_match_all($pattern, $contents, $matches)){
            echo "Found matches:\n";
            echo implode("\n", $matches[0]);
        }
        else{
            echo "No matches found";
        }
    }
    public function index()
    {
    return view('home');
    }
    
    function search(Request $request)
    {   
        // $filesInFolder = Storage::disk('confidential_files')->getDriver()->getAdapter()->applyPathPrefix('*.xml');
        if($request->ajax())
        {
        $output="";
        foreach (glob("C:/Users/z000044455/Desktop/Source/*.xml") as $filename) {
            $pattern= '/(?i)('.$request->search.')/';
            if(preg_match($pattern, basename($filename))){
                $output.='<tr class="table-tr">'.'<td>'.basename($filename).'</td>'.'</tr>';
            }
        }
        return Response($output);

        }
    }

    function openFile(Request $request)
    {   
        if($request->ajax())
        {
            // echo "<script>console.log('Debug Objects: " . $request->openFile . "' );</script>";
            // return Response( $request->openFile);

            $searchfor = 'Transition_Destination_Window';

            // the following line prevents the browser from parsing this as HTML.
            header('Content-Type: text/plain');
    
            // get the file contents, assuming the file to be readable (and exist)
            $contents = Storage::disk('fileDisk')->get($request->openFile);
            // escape special characters in the query
            $pattern = preg_quote($searchfor, '/');
            // finalise the regular expression, matching the whole line
            $pattern = "/^.*$pattern.*\$/m";
            // search, and store all matching occurences in $matches
            if(preg_match_all($pattern, $contents, $matches)){
                //echo "Found matches:\n";
                return Response( $matches[0]);
                //echo implode("\n",);
            }
            else{
                return Response( "No matches found");
            }

        }
        
    }
}
