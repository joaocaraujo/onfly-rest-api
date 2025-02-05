<?php

namespace App\Policies;

use App\Models\Expenses;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ExpensesPolicy
 */
class ExpensesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Expenses $expenses)
    {
        return $user->id === $expenses->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Expenses $expenses)
    {
        return $user->id === $expenses->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Expenses $expenses)
    {
        return $user->id === $expenses->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Expenses $expenses)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Expenses $expenses)
    {
        //
    }
}
