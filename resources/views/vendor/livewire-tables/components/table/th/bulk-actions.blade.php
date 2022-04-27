@aware(['component'])

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    @php
        $theme = $component->getTheme();
    @endphp

        <x-livewire-tables::table.th.plain>
            <input
                wire:model="selectAll"
                type="checkbox"
            />
        </x-livewire-tables::table.th.plain>
@endif
