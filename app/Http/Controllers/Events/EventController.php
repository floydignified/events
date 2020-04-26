<?php

namespace App\Http\Controllers\Events;

use App\Data\Models\Events\Event;
use App\Data\Models\Events\EventMeta;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Event Class
 */
class EventController extends BaseController
{
    /**
     * Fetch latest event
     *
     * @param Request $request
     * @return Response
     */
    public function fetch(Request $request)
    {
        //initialize variables
        $data = $request->all();
        $event = Event::orderBy('id', 'desc')
            ->with('metas')
            ->first();

        //catch if events are empty
        if (!$event) {
            return response()->json([
                "message" => "No event found.",
                "event" => [],
                "parameters" => $data,
            ], 404);
        }

        //fetch selected day names
        $selected_days = [];
        foreach ($event->metas as $meta) {
            $selected_days[] = strtolower(Carbon::parse($meta->repeat_start_date)->format('l'));
        }

        return response()->json([
            "message" => "Successfully fetched an event",
            "event" => array_merge($event->toArray(), ["selected_days" => $selected_days]),
            "parameters" => $data,
        ], 200);
    }

    /**
     * Create an event
     *
     * @param Request $request
     * @return Response
     */
    public function define(Request $request)
    {
        //initialize variables
        $data = $request->all();
        $event = new Event;

        //validate if metas are set
        if (!isset($data['days'])) {
            return response()->json([
                "message" => "Days are required.",
                "event" => [],
                "parameters" => $data,
            ], 500);
        }

        //save event data
        if (!$event->save($data)) {
            return response()->json([
                "message" => $event->errors(),
                "event" => [],
                "parameters" => $data,
            ], 500);
        }

        //save event meta data
        foreach ($data['days'] as $day) {
            $event_meta = new EventMeta;
            $end_date = Carbon::parse($event->end_date);
            $start_date = Carbon::parse($event->start_date)
                ->subDay()
                ->next($day);

            //save if within event date range
            if (!$start_date->isAfter($end_date)) {
                $meta_data = [
                    "event_id" => $event->id,
                    "repeat_start_date" => $start_date,
                ];

                $event_meta->save($meta_data);
            }
        }

        return response()->json([
            "message" => "Successfully created an event",
            "event" => $event,
            "parameters" => $data,
        ], 200);
    }
}
