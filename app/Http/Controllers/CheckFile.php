<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckFile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        
        if($_GET["filetype"] == 'mp3'){
            $dir = "./meida/mp3/";
            $filename = $_GET["youtube_id"]."."."mp3";
        }else if($_GET["filetype"]=='mp4'){
            $dir = "./media/mp4/";
            $filename = $_GET["youtube_id"]."."."mp4";
        }
        $dir="./";
        foreach(scandir($dir) as $file){
            if($file === $filename){
                return true;
            }
        }
        return false;
    }
}
