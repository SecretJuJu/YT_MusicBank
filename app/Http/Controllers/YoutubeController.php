<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\files;
require '/Users/park-yubeen/dbproject/YT_MusicBank/vendor/autoload.php';

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
            $youtube = "http://www.youtube.com/oembed?url=". $youtube_uri ."&format=json";
            
            $curl = curl_init($youtube);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($curl);
            curl_close($curl);
            
            if (json_decode($return) === null){
                return $return;
            }
            
            $retData = ['result'=>true,'uri'=>$youtube_uri];
            return view('youtube.search', ['retData'=>$retData]);
         }
         else {
            $retData = ['result'=>false,'errcode'=>2];
            return view('youtube.search', ['retData'=>$retData]);
         }
      
         

        
        
        
           
    }

    

    public function download(Request $request)
    {
        
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
        if ($_POST["filetype"]==="mp3"){
            $collection = $yt->download(
                Options::create()
                    ->downloadPath($dir)
                    ->extractAudio(true)
                    ->audioFormat("mp3")
                    ->audioQuality('0') // best
                    ->output($_POST["youtube_id"].".mp3")
                    ->url('https://www.youtube.com/watch?v='.$_POST["youtube_id"])
            );
        }else if ($_POST["filetype"] === "mp4"){
            $collection = $yt->download(
                Options::create()
                    ->downloadPath($dir)
                    ->url('https://www.youtube.com/watch?v='.$_POST["youtube_id"])
                    ->output($_POST["youtube_id"].".mp4")
            );
        }else {
            return "no hack TT";
        }
        $youtube_id = $_POST["youtube_id"];
        $name = null;
        $filesize = 0;
        foreach ($collection->getVideos() as $video) {
            if ($video->getError() !== null) {
                echo "Error downloading video: {$video->getError()}.";
            } else {
                echo "download success"; // Will return Phonebloks
                $name = $video->getTitle();
                $filesize = $video->getFilesize();
            }
        }
        
        $filehash =  hash_file( "md5", $dir."/".$_POST["youtube_id"].".".$_POST["filetype"] );
        echo $youtube_id;
        echo $name;
        echo $filesize;
        echo $filehash;

        files::create(array(
            'youtube_id' => $youtube_id,
            'name'  => $name,
            'file_size' => intval($filesize/1024),
            'file_hash' => $filehash,
            'file_type' => $_POST["filetype"]
        ));
    }
}
