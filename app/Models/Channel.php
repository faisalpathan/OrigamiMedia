<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

use App\Models\Subscription;

class Channel extends Model
{
    use Searchable;

    protected $fillable = [

    	'name',
    	'slug',
    	'description',
    	'image_filename',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImage()
    {
        if(!$this->image_filename)
        {
            return config('origamimedia.buckets.images') . '/profile/default.png';
        }

        return config('origamimedia.buckets.images') . '/profile/' . $this->image_filename;  
    }


    public function subscriptions()
    {

        return $this->hasMany(Subscription::class);

    }
    public function subscriptionCount()
    {

        return $this->subscriptions->count();

    }

    public function totalVideoViews()
    {

        //this can be done easily by foreach and count the view count but that is really show and difficult to maintain
        //yeh bolta hai ki video ka many views hai through hamare video class se
        return $this->hasManyThrough(VideoView::class, Video::class)->count();

    }

}
