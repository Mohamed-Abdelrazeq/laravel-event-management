<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index']);
        $this->middleware('throttle:api')
            ->only(['store', 'destory']);
        $this->authorizeResource(Attendee::class, 'attendee');
    }
    public function index(Event $event)
    {
        return AttendeeResource::collection($event->attendees()->latest()->paginate(10));
    }

    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create([
            "user_id" => $request->user()->id,
        ]);

        return new AttendeeResource($attendee);
    }

    public function destroy(Event $event, Attendee $attendee)
    {
        // $this->authorize('delete-attendee', [$event, $attendee]);
        $attendee = $attendee->delete();

        return response(status: 204);
    }
}
