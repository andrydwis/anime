<?php

namespace App\Livewire;

use App\Models\Link;
use Illuminate\View\View;
use Livewire\Component;

class StatShortLink extends Component
{
    public Link $linkData;

    public $name;

    public $link;

    public $customLink;

    public $password;

    public $expiredAt;

    public $generatedLink;

    public bool $isEdit = false;

    public function render(): View
    {
        return view('livewire.stat-short-link');
    }

    public function mount(): void
    {
        $this->name = $this->linkData->name;
        $this->link = $this->linkData->original_link;
        $this->customLink = $this->linkData->link;
        $this->password = $this->linkData->password;
        $this->expiredAt = $this->linkData->expired_at;
        $this->generatedLink = $this->linkData->generated_link;
    }

    public function toggleIsEdit(): void
    {
        $this->isEdit = ! $this->isEdit;
    }
}
