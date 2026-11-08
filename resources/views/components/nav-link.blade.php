@props(['route', 'icon', 'pattern' => null])

@php
    $actif = request()->routeIs($pattern ?? $route);
@endphp

<a href="{{ $route === '#' ? '#' : route($route) }}"
    class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $actif ? 'bg-[#C52F6C]' : 'hover:bg-white/10' }}">
    <i class="fas {{ $icon }} w-6 text-lg"></i>
    <span>{{ $slot }}</span>
</a>