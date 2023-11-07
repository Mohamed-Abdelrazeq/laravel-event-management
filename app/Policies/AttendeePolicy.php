<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, Attendee $attendee): bool
    {
        return $user->id === $attendee->user_id || $user->id === $attendee->event->user_id;
    }

    // public function restore(User $user, Attendee $attendee): bool
    // {
    //     //
    // }

    // public function forceDelete(User $user, Attendee $attendee): bool
    // {
    //     //
    // }
}
