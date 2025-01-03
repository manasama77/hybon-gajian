@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'hover:bg-blue-700 dark:hover:bg-blue-600 dark:hover:text-white block px-4 py-2 text-blue-700 dark:text-white bg-blue-700'
            : 'hover:bg-blue-100 dark:hover:bg-blue-600 dark:hover:text-white block px-4 py-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
