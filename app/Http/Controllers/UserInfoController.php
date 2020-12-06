<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\user_info;
use Illuminate\Support\Facades\Auth;


class UserInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show(Request $request){
        
        // return $request->user()->id;
        $infos = user_info::join('files',function ($join) use ($request) {
            $join->on('user_infos.file_hash','files.file_hash')->where('user_infos.user_id',$request->user()->id);
        })->get();

        $retData['loggined'] = true;
        $retData['userData'] = ['email'=>Auth::user()->email];
        $retData = ['result'=>true,'userData'=>['email'=>Auth::user()->email],'loggined'=>true,'infos'=>$infos];

        return view('user_info.show', ['retData'=>$retData]);
        // return view('user_info.show', compact('info'));
    }

    public function store(Request $request){
        $filetype = $request->input('filetype');
        $youtube_id = $request->input('youtube_id');
        if($filetype == 'mp3'){
            $dir = "./media/mp3";
            $filename = $youtube_id."."."mp3";
        }else if($filetype=='mp4'){
            $dir = "./media/mp4";
            $filename = $youtube_id."."."mp4";
        }
        
        $filehash =  hash_file( "md5",$dir."/".$youtube_id.".".$filetype);
        user_info::create([
            'user_id' => $request->user()->id,
            'youtube_id' => $request->youtube_id,
            'file_hash' => $filehash
        ]);
        return response()->json(array('result'=>true));
    }

}
