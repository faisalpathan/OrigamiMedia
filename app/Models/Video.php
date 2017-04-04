<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Scout\Searchable;

use App\Models\Vote;

use App\Traits\Orderable;

use App\Models\Comment;

class Video extends Model
{

	use SoftDeletes, Searchable,Orderable;

	protected $fillable = [
        'title',
        'description',
        'uid',
        'video_filename',
        'video_id',
        'processed',
        'visibility',
        'allow_votes',
        'allow_comments',
        'processed_percentage',
    ];

    //whenever we send our models to the algolia server it shows all values and therefore we can make change in the values by using a function which is toSearchableArray() jo bhai sidha change karta hai algolia ke db mein aur import karna matbulna bhai warna change hoga nahi
    public function toSearchableArray()
    {
        //this is used to update mera algolia search ko kyuki where clause in algolia on integer and boolean value here is a string check so we have to send a new request to algolia to store extra data which is to mention true or false on public videos or not goto SearchController aur info chahiye to.
        $properties = $this->toArray();
        $properties['visible'] = $this->isProcessed() && $this->isPublic();

        return $properties;
    }

    public function channel()
    {
    	return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
    	return 'uid';
    }

    // public function scopeLatestFirst($query)
    // {
    //     return $query->orderBy('created_at','desc');
    // }

    public function isProcessed()
    {
        return $this->processed;
    }

    public function getThumbnail()
    {
        if(!$this->isProcessed())
        {
            return config('origamimedia.buckets.videos') . '/nothumbnail.png' ;
        }
        return config('origamimedia.buckets.videos') . '/'. $this->video_id . '_1.jpg';
    }

    public function processedPercentage()
    {
        return $this->processed_percentage; 
    }

    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }

    public function votesComments()
    {
        return (bool) $this->allow_comments;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    public function ownedByUser(User $user)
    {

        return $this->channel->user->id === $user->id; 
    }

    public function canBeAccessed($user = null)
    {
        if(!$user &&  $this->isPrivate())
        {
             return false;
        }
        if($user && $this->isPrivate() && ($user->id !== $this->channel->user_id))  
        {
            return false;
        }

        return true; 
    }

    public function getStreamUrl()
    {
        return config('origamimedia.buckets.videos') . '/' . $this->video_id . '.mp4';
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {

        return $this->views->count();

    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'voteable');
    }


    public function upVotes()
    {

        return $this->votes->where('type','up');
    }


    public function downVotes()
    {
        //here votes() calls number of time untill found but when we use votes then it will call a collection and search through it instead of searching number of times
        return $this->votes->where('type','down');
    }


    public function voteFromUser(User $user)
    {

        return $this->votes()->where('user_id', $user->id);

    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->whereNull('reply_id');   
    }

    public function scopeProcessed($query)
    {
        return $query->where('processed',true); 
        
    }
    public function scopePublic($query)
    {
        return $query->where('visibility','public'); 
        
    }

    public function scopeVisible($query)
    {
        return $query->processed()->public();
    }

}
    