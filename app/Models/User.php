<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function channel()
    {
        return $this->hasMany(Channel::class);
    }

    //when we uploaded video we never mentioned to whom it belongs to i.e the user it belongs to to solve
    //this we create a new relationship hasManythrough samjha kya bhai

    public function videos()
    {
        return $this->hasManythrough(Video::class, Channel::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

        //yeh function list return karega jo user ne subscribe kiya hai matlab ki bhai user aur subscriber mein direct relation nahi hai isliye bhai ne "belongs to Many" ka relationship banaya iska matlab ki user belongs to channels with many subscriptions
    public function subscribedChannels()
    {
        return $this->belongsToMany(Channel::class,'subscriptions');
    }

    public function isSubscribedTo(Channel $channel)
    {
        return (bool) $this->subscriptions->where('channel_id', $channel->id)->count();
    }

    public function ownsChannel(Channel $channel)
    {

        return (bool) $this->channel->where('id',$channel->id)->count();

    }


}
