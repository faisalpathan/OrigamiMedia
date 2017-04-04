<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Jobs\UploadVideo;

class VideoUploadController extends Controller
{
    public function index()
    {
    	return view('video.upload');
    }

     public function store(Request $request)
     {
     	//grab user channel
     	// dd($request->all());
     	$channel = $request->user()->channel()->first();
     	//lookup the video 
     	$video = $channel->videos()->where('uid',$request->uid)->firstOrFail();
     	//move to temp loc

     	$request->file('video')->move(storage_path() . '/uploads', $video->video_filename);

     	//upload to s3 video bucket
     	$this->dispatch(new UploadVideo (

     		$video->video_filename


     		));

     	 return response()->json(null,200);
     }
}
