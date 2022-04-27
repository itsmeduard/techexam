@aware(['component'])
@props(['row', 'rowIndex'])

@php
    $attributes = $attributes->merge(['wire:key' => 'row-'.$rowIndex.'-'.$component->id]);
    $theme = $component->getTheme();
    $customAttributes = $this->getTrAttributes($row, $rowIndex);
@endphp
    <tr
        wire:loading.class.delay=""

        @if ($component->reorderIsEnabled() && $component->currentlyReorderingIsEnabled())
            wire:sortable.item="{{ $row->getKey() }}"
        @endif

        {{
            $attributes->merge($customAttributes)
                ->class(['' => ($customAttributes['default'] ?? true) && $rowIndex % 2 === 0])
                ->class(['' => ($customAttributes['default'] ?? true) && $rowIndex % 2 !== 0])
                ->except('default')
        }}
    >
        {{ $slot }}
    </tr>
