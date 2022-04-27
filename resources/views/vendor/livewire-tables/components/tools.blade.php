@aware(['component'])

@php
    $theme = $component->getTheme();
@endphp

<div class="d-flex flex-column">
    {{ $slot }}
</div>

