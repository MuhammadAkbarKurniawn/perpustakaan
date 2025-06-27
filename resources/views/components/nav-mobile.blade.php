@props(['route', 'label'])

@php
    $active = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="block px-3 py-2 rounded-md text-sm font-medium
       {{ $active ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
    {{ $label }}
</a>
