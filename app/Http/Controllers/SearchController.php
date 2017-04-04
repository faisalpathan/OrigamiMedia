<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Channel;

use App\Models\Video;

class SearchController extends Controller
{
    public function index(Request $request)
    {

    	if(!$request->q) 
    	{

    		return redirect('/');
    	}

    	$channels = Channel::search($request->q)->take(2)->get();

    	$videos = Video::search($request->q)->where('visible',true)->get();//scout builder sends a algolia request from here and where clause here will check for only bool and int values

    	return view('search.index', [

    		'channels' => $channels,
    		'videos' => $videos

    		]);

    }
}
