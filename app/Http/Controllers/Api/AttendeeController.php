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

    public function destroy(string $event, Attendee $attendee)
    {
        $attendee = $attendee->delete();

        return response(status: 204);
    }
}
