<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $eventsWithImageURLs = $events->map(function ($event) {
            $event->image = Storage::url('images/' . $event->image);
            return $event;
        });

        return response()->json(['events' => $eventsWithImageURLs]);
    }

    public function getEventsByDate(Request $request, $date)
    {
        $event = Event::whereDate('from', $date)->first();

        if (!$event) {
            return response()->json(['message' => 'No event found for the specified date'], 404);
        }

        $event->image = Storage::url('images/' . $event->image);

        return response()->json(['event' => $event]);
    }
}
