@aware(['component'])
@props(['row'])

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    @php
        $theme = $component->getTheme();
    @endphp

    <x-livewire-tables::table.td.plain>
        <input
            wire:model="selected"
            wire:loading.attr.delay="disabled"
            value="{{ $row->{$this->getPrimaryKey()} }}"
            type="checkbox"
        />
    </x-livewire-tables::table.td.plain>
@endif
