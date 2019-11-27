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
            if($output!=""){
                return Response($output);
            }
            else{
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
                //Response( $matches[0])
                $path = array(1000);
                $root = $request->openFile;
                $output=$this->findPathsRecur($root,$path,0);
                return Response($output);
                //echo implode("\n",);
            }
            else{
                return Response( "No matches found");
            }

        }
        
    }

    function findPathsRecur($root,&$path,$length){
        $path[$length] = $root;
        $length=$length+1;
        $transitions=array();
        $searchfor = 'Transition_Destination_Window';
        header('Content-Type: text/plain');
        if(Storage::disk('fileDisk')->exists($root)){
        $contents = Storage::disk('fileDisk')->get($root);
        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if(preg_match_all($pattern, $contents, $matches)){
                foreach($matches[0] as $filename){
                    $str1 = (explode('>',$filename,2));
                    $str2 = (explode('<',$str1[1],2));
                    $str2[0] .= ".xml";
                    array_push($transitions,$str2[0]);
                }
            foreach ($transitions as $match) {
                $this->findPathsRecur($match,$path,$length);
                return $path;
                //return $transitions;
            }
        }
        }
        else{
            return $path;
        }
        
    }
}
