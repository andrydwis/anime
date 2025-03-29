<x-layouts.app>
    @foreach ($pages as $page)
        <img
            data-src="{{ $page['img'] }}"
            alt="{{ $page['page'] }}"
            loading="lazy"
            class="lazy"
        >
    @endforeach

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@19.1.3/dist/lazyload.min.js">
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var lazyLoadInstance = new LazyLoad({
                    elements_selector: ".lazy"
                });
            });
        </script>
    @endpush
</x-layouts.app>
