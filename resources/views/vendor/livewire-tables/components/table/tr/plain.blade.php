@aware(['component'])
@props(['customAttributes' => []])

@php
    $theme = $component->getTheme();
@endphp

    <tr {{ $attributes
        ->merge($customAttributes)
        ->class(['' => $customAttributes['default'] ?? true])
        ->except('default')
    }}>
        {{ $slot }}
    </tr>

