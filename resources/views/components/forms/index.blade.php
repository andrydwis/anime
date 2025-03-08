@props([
    'method' => 'POST',
])
<form
    {{ $attributes }}
    method="{{ $method != 'GET' ? 'POST' : 'GET' }}"
    enctype="multipart/form-data"
>
    @if ($method != 'GET')
        @csrf
        @method($method)
    @endif
    {{ $slot }}
</form>
