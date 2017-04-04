<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Orderable;

class Comment extends Model
{

	use SoftDeletes, Orderable;

    protected $fillable = [

    'body',
    'user_id',
    'reply_id',

    ];

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function replies()
    {
    	//relating this to itself is possible in polymorphic relation isliye for foreign we use reply_id and local ke liye id.
    	return $this->hasMany(Comment::class,'reply_id','id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
