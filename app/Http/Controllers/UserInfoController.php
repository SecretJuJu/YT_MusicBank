<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\user_info;

class UserInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request){
        
        // return $request->user()->id;
        return user_info::join('files',function ($join) use ($request) {
            $join->on('user_infos.file_hash', '=', 'files.file_hash')->where('user_infos.user_id','=',$request->user()->id);
        })->get();
    }

    public function store(Request $request){
        user_info::create([
            'user_id' => $request->user()->id,
            'youtube_id' => $request->youtube_id,
        ]);
        
        return redirect()->back();
    }
}
