<?php

namespace App\Livewire;

use App\Models\Region;
use Illuminate\View\View;
use Livewire\Component;

class RegionInput extends Component
{
    public array $provinces = [
    ];

    public array $cities = [
        ['id' => 0, 'name' => 'Pilih provinsi daulu'],
    ];

    public int $selectedProvince = 0;

    public int $selectedCity = 0;

    public function render(): View
    {
        return view('livewire.region-input');
    }

    public function mount(): void
    {
        $this->provinces = Region::where('parent_id', null)->get()->toArray();

        if ($this->selectedProvince) {
            $this->cities = Region::where('parent_id', $this->selectedProvince)->get()->toArray();
        }
    }

    public function updatedSelectedProvince(): void
    {
        $this->cities = Region::where('parent_id', $this->selectedProvince)->get()->toArray();
    }
}
