<div class="container-fluid">
    <div class="card shadow">
        <div class='card-header py-3' wire:ignore>
            <p class='text-primary m-0 fw-bold'>Phonebook Information
                @if(
                        request()->routeIs('phonebook*')
                    )
                    <a class='btn btn-primary float-end btn-icon-split' role='button' data-bs-target="#importModal" data-bs-toggle='modal'>
                        <span class='text-white-50 icon'>
                            <i class='fas fa-plus'></i>
                        </span>
                        <span class='text-white text'>Import</span>
                    </a>
                @endif

            </p>
        </div>
        <div class="card-body">
        <x-livewire-tables::wrapper :component="$this">
            <x-livewire-tables::tools>
                <x-livewire-tables::tools.sorting-pills />
                <x-livewire-tables::tools.filter-pills />
                <x-livewire-tables::tools.toolbar />
            </x-livewire-tables::tools>

            <x-livewire-tables::table>
                <x-slot name="thead">
                    <x-livewire-tables::table.th.reorder />
                    <x-livewire-tables::table.th.bulk-actions />
                    <x-livewire-tables::table.th.row-contents />

                    @foreach($columns as $index => $column)
                        @continue($column->isHidden())
                        @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))
                        @continue($this->currentlyReorderingIsDisabled() && $column->isReorderColumn() && $this->hideReorderColumnUnlessReorderingIsEnabled())

                        <x-livewire-tables::table.th :column="$column" :index="$index" />
                    @endforeach
                </x-slot>

                @if($this->secondaryHeaderIsEnabled() && $this->hasColumnsWithSecondaryHeader())
                    <x-livewire-tables::table.tr.secondary-header :rows="$rows" />
                @endif

                <x-livewire-tables::table.tr.bulk-actions :rows="$rows" />

                @forelse ($rows as $rowIndex => $row)
                    <x-livewire-tables::table.tr :row="$row" :rowIndex="$rowIndex">
                        <x-livewire-tables::table.td.reorder />
                        <x-livewire-tables::table.td.bulk-actions :row="$row" />
                        <x-livewire-tables::table.td.row-contents :rowIndex="$rowIndex" />

                        @foreach($columns as $colIndex => $column)
                            @continue($column->isHidden())
                            @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))
                            @continue($this->currentlyReorderingIsDisabled() && $column->isReorderColumn() && $this->hideReorderColumnUnlessReorderingIsEnabled())

                            <x-livewire-tables::table.td :column="$column" :colIndex="$colIndex">
                                {{ $column->renderContents($row) }}
                            </x-livewire-tables::table.td>
                        @endforeach
                    </x-livewire-tables::table.tr>

                    <x-livewire-tables::table.row-contents :row="$row" :rowIndex="$rowIndex" />
                @empty
                    <x-livewire-tables::table.empty />
                @endforelse

                @if ($this->footerIsEnabled() && $this->hasColumnsWithFooter())
                    <x-slot name="tfoot">
                        @if ($this->useHeaderAsFooterIsEnabled())
                            <x-livewire-tables::table.tr.secondary-header :rows="$rows" />
                        @else
                            <x-livewire-tables::table.tr.footer :rows="$rows" />
                        @endif
                    </x-slot>
                @endif
            </x-livewire-tables::table>

            <x-livewire-tables::pagination :rows="$rows" />
        </x-livewire-tables::wrapper>
        </div>
    </div>
</div>
