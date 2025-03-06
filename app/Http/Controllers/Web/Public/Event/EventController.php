<?php

namespace App\Http\Controllers\Web\Public\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Cache::remember('events-'.request()->input('page', 1), now()->addMinutes(5), function () {
            return Event::where('is_published', true)->orderBy('start_date', 'asc')->orderBy('created_at', 'desc')->with(['media'])->paginate(10)->withQueryString();
        });

        $data = [
            'events' => $events,
        ];

        return view('public.event.index', $data);
    }

    public function show(Event $event): View
    {
        if ($event->is_published == false) {
            abort(404);
        }

        $data = [
            'event' => $event,
        ];

        return view('public.event.show', $data);
    }
}
