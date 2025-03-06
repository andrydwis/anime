<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

class SwitchPublishEvent extends Component
{
    public Event $event;

    public bool $isPublished = false;

    public function render(): View
    {
        return view('livewire.switch-publish-event');
    }

    public function mount(): void
    {
        $this->isPublished = $this->event->is_published;
    }

    public function updatedIsPublished()
    {
        $this->event->is_published = ! $this->event->is_published;
        $this->event->save();

        Cache::clear('events');
    }
}
