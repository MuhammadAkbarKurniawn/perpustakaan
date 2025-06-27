@props(['route', 'label'])

@php
    $active = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="px-3 py-2 rounded-md text-sm font-medium
       {{ $active ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    {{ $label }}
</a>
