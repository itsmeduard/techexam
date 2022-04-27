@aware(['component'])
@props(['rows'])

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions() && $component->hasSelected())
    @php
        $table = $component->getTableName();
        $theme = $component->getTheme();
        $colspan = $component->getColspanCount();
        $selected = $component->getSelectedCount();
        $selectAll = $component->selectAllIsEnabled();
    @endphp

        <x-livewire-tables::table.tr.plain
            wire:key="bulk-select-message-{{ $table }}"
        >
            <x-livewire-tables::table.td.plain :colspan="$colspan">
                @if ($selectAll)
                    <div wire:key="all-selected-{{ $table }}">
                        <span>
                            @lang('You are currently selecting all')
                            <strong>{{ number_format($rows->total()) }}</strong>
                            @lang('rows').
                        </span>

                        <button
                            wire:click="clearSelected"
                            wire:loading.attr="disabled"
                            type="button"
                            class="btn btn-primary btn-sm"
                        >
                            @lang('Deselect All')
                        </button>
                    </div>
                @else
                    <div wire:key="some-selected-{{ $table }}">
                        <span>
                            @lang('You have selected')
                            <strong>{{ $selected }}</strong>
                            @lang('rows, do you want to select all')
                            <strong>{{ number_format($rows->total()) }}</strong>?
                        </span>

                        <button
                            wire:click="setAllSelected"
                            wire:loading.attr="disabled"
                            type="button"
                            class="btn btn-primary btn-sm"
                        >
                            @lang('Select All')
                        </button>

                        <button
                            wire:click="clearSelected"
                            wire:loading.attr="disabled"
                            type="button"
                            class="btn btn-primary btn-sm"
                        >
                            @lang('Deselect All')
                        </button>
                    </div>
                @endif
            </x-livewire-tables::table.td.plain>
        </x-livewire-tables::table.tr.plain>

@endif
