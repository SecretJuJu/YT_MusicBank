<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\files;
require '/Users/secret/Documents/GitHub/YT_MusicBank/vendor/autoload.php';

use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;

class YoutubeController extends Controller
{
    public function check_youtubeUrl($uri)
    {
        $youtube_uri = urldecode($uri);
         // Distinguish if it is a YouTube link
        if(!preg_match("/^(https:\/\/|http:\/\/)(www\.youtube\.com|youtube\.com)\/*\/watch\?*(v=)/i", $youtube_uri)){
            $retData = ['result'=>false,'errcode'=>2];
            return false;
        }
        else return true;
    }


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
         if($this->check_youtubeUrl($youtube_uri)){
            $retData = ['result'=>true];
            return view('youtube.search', ['retData'=>$retData]);
         }
         else {
            $retData = ['result'=>false,'errcode'=>2];
            return view('youtube.search', ['retData'=>$retData]);
         }
      

        // 링크가 유효하다면 result : true 아니라면 result : false
        

        // true 일때 mp3 로 다운로드 할지 mp4로 다운로드할지 선택
    }

    

    public function download(Request $request)
    {
        return "it works";

        if($_POST["filetype"] == 'mp3'){
            $dir = "./media/mp3";
            $filename = $_POST["youtube_id"]."."."mp3";
        }else if($_POST["filetype"]=='mp4'){
            $dir = "./media/mp4";
            $filename = $_POST["youtube_id"]."."."mp4";
        }

        foreach(scandir($dir) as $file){
            if($filename === $file){
                return "file exist";
            }
        }
        $yt = new YoutubeDl();
        
        $collection = $yt->download(
            Options::create()
                ->downloadPath($dir)
                ->url('https://www.youtube.com/watch?v='.$_POST['youtube_id'])
        );

        foreach ($collection->getVideos() as $video) {
            if ($video->getError() !== null) {
                echo "Error downloading video: {$video->getError()}.";
            } else {
            echo $video->getTitle(); // Will return Phonebloks
            // $video->getFile(); // \SplFileInfo instance of downloaded file
            }
        }
        
    }
}
