<?php

namespace App\Livewire;

use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

class SwitchPublishNews extends Component
{
    public News $news;

    public bool $isPublished = false;

    public function render(): View
    {
        return view('livewire.switch-publish-news');
    }

    public function mount(): void
    {
        $this->isPublished = $this->news->is_published;
    }

    public function updatedIsPublished()
    {
        $this->news->is_published = ! $this->news->is_published;
        $this->news->save();

        Cache::clear('news');
    }
}
