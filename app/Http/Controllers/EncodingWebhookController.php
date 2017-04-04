<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Video;


class EncodingWebhookController extends Controller
{
    public function handle(Request $request)
    {

    	$event = camel_case($request->event);

    	if(method_exists($this, $event))
    	{
    		$this->{$event}($request); //yaha event select kiya aur usme request the object pass kiya
    	}

    }

    protected function videoEncoded(Request $request)
    {
    	//look up the video
    	$video = $this->getVideoByFilename($request->original_filename);
    	//update the processed column
    	$video->processed = true;
    	$video->video_id = $request->encoding_ids[0];
    	$video->save();
    }

    protected function encodingProgress(Request $request)
    {
    	//
	 	$video = $this->getVideoByFilename($request->original_filename);
	 	$video->processed_percentage = $request->progress;
	 	$video->save();

    }

    protected function getVideoByFilename($filename)
    {

    	return Video::where('video_filename',$filename)->firstOrFail();	

    }
}

