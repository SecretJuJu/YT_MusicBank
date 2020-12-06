<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\files;
require '/Users/secret/Documents/GitHub/YT_MusicBank/vendor/autoload.php';
use Illuminate\Support\Facades\Auth;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;



function get_youtube_title($video_id){
    $youtube = "http://www.youtube.com/oembed?url="."https://youtube.com/watch?v=".$video_id."&format=json";
    $curl = curl_init($youtube);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($curl);
    curl_close($curl);
    return json_decode($return, true);
}
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
                $retData = ['result'=>false,'errcode'=>3];
                return view('youtube.search', ['retData'=>$retData]);
            }
            if (Auth::check()){
                $retData = ['result'=>true,'uri'=>$youtube_uri, 'userData'=>['email'=>Auth::user()->email],'loggined'=>true];
            }else {
                $retData = ['result'=>true,'uri'=>$youtube_uri];
            }
            return view('youtube.search', ['retData'=>$retData]);
         }
         else {
            $retData = ['result'=>false,'errcode'=>2];
            return view('youtube.search', ['retData'=>$retData]);
         }
    }

    

    public function download(Request $request)
    {
       
        $filetype = $request->input('filetype');
        $youtube_id = $request->input('youtube_id');
        if( !(isset($filetype) && isset($youtube_id))){
            return response()->json(array('result'=>false),200);
        }

        if($filetype == 'mp3'){
            $dir = "./media/mp3";
            $filename = $youtube_id."."."mp3";
        }else if($filetype=='mp4'){
            $dir = "./media/mp4";
            $filename = $youtube_id."."."mp4";
        }
        
        foreach(scandir($dir) as $file){
            if($filename === $file){
                try{
                    $element = files::where("youtube_id","=",$youtube_id)->first() ;
                    if($element != null){
                        return response()->json(array('result'=>true,'path'=>$dir."/".$youtube_id.".".$filetype,'name'=>$element['name']),200);
                    }
                } catch(Exception $e){
                    return response()->json(array('result'=>false),200);
                }
            }
        }
        $yt = new YoutubeDl();
        if ($filetype==="mp3"){
            $collection = $yt->download(
                Options::create()
                    ->downloadPath($dir)
                    ->extractAudio(true)
                    ->audioFormat("mp3")
                    ->audioQuality('0') // best
                    ->output($youtube_id.".mp3")
                    ->url('https://www.youtube.com/watch?v='.$youtube_id)
            );
        }else if ($filetype === "mp4"){
            $collection = $yt->download(
                Options::create()
                    ->downloadPath($dir)
                    ->url('https://www.youtube.com/watch?v='.$youtube_id)
                    ->output($youtube_id.".mp4")
            );
        }else {
            return "no hack TT";
        }
        try{
            
            foreach ($collection->getVideos() as $video) {
                if ($video->getError() !== null) {
                    return response()->json(array('result'=>false,'error'=>$video->getError()),200);
                }
            }
            
            
        } catch (Exception $e) {
            return response()->json(array('result'=>false),200);
        } finally {
            foreach(scandir($dir) as $file){
                if($filename === $file){
                    $element = files::where("youtube_id","=",$youtube_id)->where("file_type","=",$filetype)->first();
                    $name = get_youtube_title($youtube_id)['title'];
                    $filehash =  hash_file( "md5", $dir."/".$youtube_id.".".$filetype);
                    $filesize = filesize($dir."/".$youtube_id.".".$filetype);
                    if($element == null){
                        files::create(array(
                            'youtube_id' => $youtube_id,
                            'name'  => $name,
                            'file_size' => intval($filesize/1024),
                            'file_hash' => $filehash,
                            'file_type' => $filetype
                        ));
                    }
                    return response()->json(array('result'=>true,'path'=>$dir."/".$youtube_id.".".$filetype,'name'=> $name),200);
                }
            }
            return response()->json(array('result'=>false));
        }
        
    }
}
