<?php

namespace App\Http\Controllers\Web\Core\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class EventController extends Controller
{
    public function index(): View
    {
        $data = [
            'events' => Event::latest()->with(['media'])->paginate(10)->withQueryString(),
        ];

        return view('core.event.index', $data);
    }

    public function create(): View
    {
        return view('core.event.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'province_id' => ['nullable', 'exists:regions,id'],
            'city_id' => ['nullable', 'exists:regions,id'],
        ]);

        $htmlSanitizer = new HtmlSanitizer(
            (new HtmlSanitizerConfig)->allowSafeElements()
        );
        $content = $htmlSanitizer->sanitize($request->input('content'));

        $event = new Event;
        $event->name = $request->input('name');
        $event->slug = Str::slug($request->input('name')).'-'.Carbon::now()->timestamp;
        $event->content = $content;
        $event->start_date = $request->input('start_date');
        $event->end_date = $request->input('end_date');
        $event->province_id = $request->input('province_id');
        $event->city_id = $request->input('city_id');
        $event->user_id = Auth::id();
        $event->save();

        if ($request->hasFile('image')) {
            $event->addMediaFromRequest('image')->toMediaCollection('event');
        }

        Cache::clear('events');

        session()->flash('success', 'Event berhasil ditambahkan.');

        return redirect()->route('core.events.index');
    }

    public function edit(Event $event): View
    {
        $data = [
            'event' => $event,
        ];

        return view('core.event.edit', $data);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'province_id' => ['nullable', 'exists:regions,id'],
            'city_id' => ['nullable', 'exists:regions,id'],
        ]);

        $htmlSanitizer = new HtmlSanitizer(
            (new HtmlSanitizerConfig)->allowSafeElements()
        );
        $content = $htmlSanitizer->sanitize($request->input('content'));

        $event->name = $request->input('name');
        $event->content = $content;
        $event->start_date = $request->input('start_date');
        $event->end_date = $request->input('end_date');
        $event->province_id = $request->input('province_id');
        $event->city_id = $request->input('city_id');
        $event->save();

        if ($request->hasFile('image')) {
            $event->clearMediaCollection('event');
            $event->addMediaFromRequest('image')->toMediaCollection('event');
        }

        Cache::clear('events');

        session()->flash('success', 'Event berhasil diubah.');

        return redirect()->route('core.events.index');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        Cache::clear('events');

        session()->flash('success', 'Event berhasil dihapus.');

        return redirect()->route('core.events.index');
    }
}
