<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Channel;

use App\Http\Requests\ChannelUpdateRequest;

use App\Jobs\UploadImage;

class ChannelSettingsController extends Controller
{
    

    public function edit(Channel $channel)
    {
    	//dd($channel);
    	$this->authorize('edit',$channel);

    	return view('channel.settings.edit', [ 
    		
    		'channel' => $channel 

    		]); 
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {

    	$this->authorize('update',$channel);

    	$channel->update([
    		
    		'name' => $request->name,
    		'slug' => $request->slug,
    		'description' => $request->description,

    		]);

        if($request->file('image')) {

            //move to temp loc
            $request->file('image')->move(storage_path() . '/uploads',$fileId = uniqid(true));
            //dispatch a job (queue testing)
            $this->dispatch(new UploadImage($channel,$fileId));
        }

    	return redirect()->to("/channel/{$channel->slug}/edit");
    }
}
