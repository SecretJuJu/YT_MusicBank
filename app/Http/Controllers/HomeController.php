<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $retData = ['loggined'=>false,'userData'=>null];
        if (Auth::check()){
            $retData['loggined'] = true;
            $retData['userData'] = ['email'=>Auth::user()->email];
        }
        return dd($retData);
        return view('home')->with($retData);
    }
}
