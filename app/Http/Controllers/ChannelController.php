<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Channel;

class ChannelController extends Controller
{
    public function  show(Channel $channel)
    {
    	//dd($channel->totalVideoViews());
    	return view('channel.show', [

    		'channel' => $channel,

    		'videos' => $channel->videos()->visible()->latestFirst()->paginate(5),



    		]);

    }
}
