<?php

namespace App\Policies;

use App\Models\Dish;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DishPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('get dish')
            ? Response::allow()
            : Response::deny('You cannot retrieve dishes.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Dish $dish): Response
    {
        return $user->hasPermissionTo('get dish')
            ? Response::allow()
            : Response::deny('You cannot retrieve dishes.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('publish dish')
            ? Response::allow()
            : Response::deny('You cannot create a dish.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->hasPermissionTo('edit dish')
            ? Response::allow()
            : Response::deny('You do not own this dish.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->hasPermissionTo('delete dish')
            ? Response::allow()
            : Response::deny('You do not own this dish.');
    }
}
