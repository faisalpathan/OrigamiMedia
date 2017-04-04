<?php

namespace App\Http\Controllers;

use App\Models\Video;

use Illuminate\Http\Request;

use App\Http\Requests\VideoUpdateRequest;

use App\Http\Requests\VideoCreateRequest;

use App\Http\Requests;


class VideoController extends Controller
{

    public function show (Video $video)
    {

        return view('video.show',[

            'video' => $video 
            ]);

    }

    public function index(Request $request)
    {

            $videos = $request->user()->videos()->latestFirst()->paginate(6);


            return view('video.index',[

                   'videos' => $videos,

                ]);

    }

    public function edit(Video $video)
    {
        //authorize
        $this->authorize('edit',$video);

        return view('video.edit')->with('video',$video);

    }

    public function delete(Video $video)
    {

        $this->authorize('delete',$video);

        dd($video->title);

        $video->delete();

        return redirect()->back();

    }

	public function update(VideoUpdateRequest $request,Video $video)
	{
        $this->authorize('update',$video);

        $video->update([

            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),

            ]);

        //agar ajax request hai toh kuch toh response bhej blank mat
        if($request->ajax())
        {
            return response()->json(null, 200);

        }

        return redirect()->back();
        //return redirect()->to("/videos");
		
	}
    public function store(VideoCreateRequest $request)
    {
        //to check we do aborting the page
        //abort(500);
    	//generate uid
    	$uid=uniqid(true);
    	//grab the user's channel
        $channel = $request->user()->channel()->first();   

        $video = $channel->videos()->create([
        	
        		'uid' => $uid,
        		'title' => $request->title,
        		'description' => $request->description,
        		'visibility'  => $request->visibility,
        		'video_filename' => "{$uid}.{$request->extension}",

        	]);
       
       return response()->json(['uid' => $uid]);
               // dd("hello");
		}

}
