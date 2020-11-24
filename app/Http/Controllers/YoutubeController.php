<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\files;

class YoutubeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');

    }   
    public function search(Request $request)
    {
         // checking uri param set
        $retData = [];
        if(!isset($_GET['uri'])){
            $retData = ['result'=>false,'errcode'=>1];
            return view('youtube.search', ['retData'=>$retData]);
        }

        $youtube_uri = urldecode($_GET['uri']);
         // Distinguish if it is a YouTube link
        if(!preg_match("/^(https:\/\/|http:\/\/)(www\.youtube\.com|youtube\.com)\/*\/watch\?*(v=)/i", $youtube_uri)){
            $retData = ['result'=>false,'errcode'=>2];
            return view('youtube.search', ['retData'=>$retData]);
        }

        return dd($_GET['uri']);
    }
}
