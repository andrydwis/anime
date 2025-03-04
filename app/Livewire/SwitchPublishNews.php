<?php

namespace App\Livewire;

use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SwitchPublishNews extends Component
{
    public News $news;

    public bool $isPublished = false;

    public function render()
    {
        return view('livewire.switch-publish-news');
    }

    public function mount()
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
