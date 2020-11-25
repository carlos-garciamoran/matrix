<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the $post is owned by the $user.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function update(User $user, Post $post) {
        return $post->user_id === $user->id;
    }

    /**
     * Determine if the $post is owned by the $user or if $user is a moderator.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete(User $user, Post $post) {
        return $this->update($user, $post) || $user->moderator;
    }
}
