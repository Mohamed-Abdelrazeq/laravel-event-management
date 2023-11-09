<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notification to all event attendees that event starts in 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $evets = \App\Models\Event::with('attendees.user')
            ->whereBetween('start_date', [now(), now()->addDay()])
            ->get();

        $eventCount = $evets->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info("Found {$eventCount} {$eventLabel}");

        $evets->each(
            fn($event) =>
            $event->attendees->each(
                fn($attendee) =>
                $this->info("Notifying the user {$attendee->user->id} abouth event {$event->name}")
            )
        );

        $this->info('Reminder notification sent successfully');
    }
}
