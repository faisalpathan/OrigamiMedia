<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Comment;

use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function delete(User $user , Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
