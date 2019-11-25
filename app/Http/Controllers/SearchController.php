<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
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
            return Response( $request->openFile);

        }
        
    }
}
