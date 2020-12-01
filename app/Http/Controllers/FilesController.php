<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function check(Request $request)
    {
        
        if(isset($_GET["youtube_id"]) && isset($_GET["file"])){
            return "wrong data";
        }
        if($_GET["filetype"] == 'mp3'){
            $dir = "./media/mp3";
            $filename = $_GET["youtube_id"]."."."mp3";
        }else if($_GET["filetype"]=='mp4'){
            $dir = "./media/mp4";
            $filename = $_GET["youtube_id"]."."."mp4";
        }
        
        foreach(scandir($dir) as $file){
            if($filename === $file){
                return "{\"result\" : true}";
            }
        }
        return "{\"result\":false}";
    }
}
