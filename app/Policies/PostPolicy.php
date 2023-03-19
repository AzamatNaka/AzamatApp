<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) //index
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post) // show
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) // create, store
    {
        return $user->role->name == 'user' || 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post) //update
    {
        return ($user->id == $post->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post) // delete
    {
        return ($user->id == $post->user_id) || ($user->role->name != 'user');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
