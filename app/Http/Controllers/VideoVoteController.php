<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Video;

use App\Http\Requests\CreateVoteRequest;

class VideoVoteController extends Controller
{

		//delete kar pehle user ne jo vote kiya tha is video pe 

		//phir create maar new  record jo hai
	public function create(CreateVoteRequest $request,Video $video)
	{

		$this->authorize('vote',$video);

		//yaha ek bohot bada problem aya tha ki please go and see the voteFromUser ka function in video model now that function if you want the data from a function do not mentioned () in calling the function and if you want just the relationship then you have to call it using () i.e votes() bohot tym lagaya bhai
		
		//dd($video->voteFromUser($request->user()));
		$video->voteFromUser($request->user())->delete();

		$video->votes()->create([

			'type' => $request->type,
			'user_id' => $request->user()->id,

			]);

		return response()->json(null,200);

	}

	public function delete(Request $request,Video $video)
	{

		$this->authorize('vote',$video);

		//dd($video->voteFromUser($request->user()));

		$video->voteFromUser($request->user())->delete();

		return response()->json(null,200);

	}


    public function show(Request $request, Video $video)
    {

    	//set defaults

    	$response = [

    		 'up' => null,
    		 'down' => null,
    		 'can_vote' => $video->votesAllowed(),
    		 'user_vote' => null,

    	]; 
    	// check if votes allowed

    	if ($video->votesAllowed()) {

    		$response['up'] = $video->upVotes()->count();
    		$response['down'] = $video->downVotes()->count();
    	}

    	//check user vote 
    	// yeh jo $request->user() hai yeh dega meko logged in current user
    	if($request->user()) {

    		$voteFromUser = $video->voteFromUser($request->user())->first();



    		$response['user_vote'] = $voteFromUser ? $voteFromUser->type : null ;


    	}

    	return response()->json([

    		"up" => $response['up'],
    		"down" => $response['down'],
    		"user_vote" => $response['user_vote'],
    		"can_vote" => $response['can_vote'],

    	], 200);




    }
}
