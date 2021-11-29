@props(['active'])

@php
$classes = ($active ?? false)
            ? 'active px-1 mt-2'
            : 'px-1 mt-2 my-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
