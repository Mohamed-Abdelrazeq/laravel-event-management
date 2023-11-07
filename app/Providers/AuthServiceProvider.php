<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define(
            'modify-event',
            fn(User $user, Event $event) => $user->id === $event->user_id
        );

        Gate::define(
            'delete-attendee',
            fn(User $user, Event $event, Attendee $attendee)
            => $user->id === $attendee->user_id || $user->id === $event->user_id
        );
    }
}
