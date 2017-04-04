<?php


namespace App\Repositories;

use App\Models\User;


class UserRepository
{

	public function videosFromSubscriptions(User $user,$limit = 5)
	{

//bohot complex query isliye lets understand pehle user nikala jo channel ko subscribed hai phir unke data aya wo hai channel ka data phir ek closure function mein query pass kiya (see Video.php) for the scope functions toh uske baad channel ke videos ko pluck kiya conditions check kiya ki video processed hai kya aur public hai kya
		return $user->subscribedChannels()->with(['videos' => function ($query) use ($limit) 
			{
				$query->visible()->take($limit); 
			}])->get()->pluck('videos')->flatten()->sortByDesc('created_at');



	}

}

?>