<div class="grid grid-cols-2 gap-2">
    <flux:select
        label="Provinsi"
        name="province_id"
        wire:model.change="selectedProvince"
        value="{{ old('province') }}"
        placeholder="Pilih provinsi"
    >
        @foreach ($provinces as $province)
            <flux:select.option value="{{ $province['id'] }}">{{ $province['name'] }}
            </flux:select.option>
        @endforeach
    </flux:select>

    <flux:select
        label="Kota"
        name="city_id"
        wire:model.change="selectedCity"
        value="{{ old('city') }}"
        placeholder="Pilih kota"
        :disabled="!$selectedProvince"
    >
        @foreach ($cities as $city)
            <flux:select.option value="{{ $city['id'] }}">{{ $city['name'] }}
            </flux:select.option>
        @endforeach
    </flux:select>
</div>
