@aware(['component'])

@php
    $theme = $component->getTheme();
@endphp

<div class="d-md-flex justify-content-between mb-3">
    <div class="d-md-flex">
        @if ($component->reorderIsEnabled())
            <div class="me-0 me-md-2 mb-3 mb-md-0">
                <button
                    wire:click="{{ $component->currentlyReorderingIsEnabled() ? 'disableReordering' : 'enableReordering' }}"
                    type="button"
                    class="btn btn-default d-block w-100 d-md-inline"
                >
                    @if ($component->currentlyReorderingIsEnabled())
                        @lang('Done Reordering')
                    @else
                        @lang('Reorder')
                    @endif
                </button>
            </div>
        @endif

        @if ($component->searchIsEnabled() && $component->searchVisibilityIsEnabled())
            <div class="mb-3 mb-md-0 input-group">
                <input
                    wire:model{{ $component->getSearchOptions() }}="{{ $component->getTableName() }}.search"
                    placeholder="{{ __('Search') }}"
                    type="text"
                    class="form-control"
                >

                @if ($component->hasSearch())
                    <button wire:click.prevent="clearSearch"  class="btn btn-outline-secondary" type="button">
                        <svg style="width:.75em;height:.75em" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        @endif

        @if ($component->filtersAreEnabled() && $component->filtersVisibilityIsEnabled() && $component->hasFilters())
            <div class="{{ $component->searchIsEnabled() ? 'ms-0 ms-md-2' : '' }} mb-3 mb-md-0">
                <div
                    @if ($component->isFilterLayoutPopover())
                        x-data="{ open: false }"
                        x-on:keydown.escape.stop="open = false"
                        x-on:mousedown.away="open = false"
                    @endif

                    class="btn-group d-block d-md-inline"
                >
                    <div>
                        <button
                            type="button"
                            class="btn dropdown-toggle d-block w-100 d-md-inline"

                            @if ($component->isFilterLayoutPopover())
                                x-on:click="open = !open"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                                aria-expanded="true"
                            @endif

                            @if ($component->isFilterLayoutSlideDown())
                                x-on:click="filtersOpen = !filtersOpen"
                            @endif
                        >
                            @lang('Filters')

                            @if ($component->hasAppliedFiltersWithValues())
                                <span class="badge bg-info">
                                    {{ $component->getAppliedFiltersWithValuesCount()}}
                                </span>
                            @endif

                            <span class="caret"></span>
                        </button>
                    </div>

                    @if ($component->isFilterLayoutPopover())
                        <ul
                            wire:key='{{ $component->getTableName() }}-filters-popover-menu'
                            x-cloak
                            class="dropdown-menu w-100"
                            x-bind:class="{'show' : open}"
                            role="menu"
                        >
                            @foreach($component->getFilters() as $filter)
                                <div wire:key="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" class="p-2">
                                    <label for="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" class="mb-2">
                                        {{ $filter->getName() }}
                                    </label>

                                    {{ $filter->render($component) }}
                                </div>
                            @endforeach

                            @if ($component->hasAppliedFiltersWithValues())
                                <div class="dropdown-divider"></div>

                                <button
                                    wire:click.prevent="setFilterDefaults"
                                    x-on:click="open = false"
                                    class="dropdown-item text-center"
                                >
                                    @lang('Clear')
                                </button>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="d-md-flex">
        @if ($component->showBulkActionsDropdown())
            <div class="mb-3 mb-md-0">
                <div class="dropdown d-block d-md-inline">
                    <button class="btn dropdown-toggle d-block w-100 d-md-inline" type="button" id="{{ $component->getTableName() }}-bulkActionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('Bulk Actions')
                    </button>

                    <div class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="{{ $component->getTableName() }}-bulkActionsDropdown">
                        @foreach($component->getBulkActions() as $action => $title)
                            <a
                                href="#"
                                wire:click.prevent="{{ $action }}"
                                wire:key="bulk-action-{{ $action }}-{{ $component->getTableName() }}"
                                class="dropdown-item"
                            >
                                {{ $title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($component->columnSelectIsEnabled())
            <div class="mb-3 mb-md-0 md-0 ms-md-2">
                <div
                    x-data="{ open: false }"
                    x-on:keydown.escape.stop="open = false"
                    x-on:mousedown.away="open = false"
                    class="dropdown d-block d-md-inline"
                    wire:key="column-select-button-{{ $component->getTableName() }}"
                >
                    <button
                        x-on:click="open = !open"
                        class="btn dropdown-toggle d-block w-100 d-md-inline"
                        type="button"
                        id="columnSelect-{{ $component->getTableName() }}"
                        aria-haspopup="true"
                        x-bind:aria-expanded="open"
                    >
                        @lang('Columns')
                    </button>

                    <div
                        class="dropdown-menu dropdown-menu-end w-100"
                        x-bind:class="{'show' : open}"
                        aria-labelledby="columnSelect-{{ $component->getTableName() }}"
                    >
                        @foreach($component->getColumns() as $column)
                            @if ($column->isVisible() && $column->isSelectable())
                                <div wire:key="columnSelect-{{ $loop->index }}-{{ $component->getTableName() }}">
                                    <label
                                        wire:loading.attr="disabled"
                                        wire:target="selectedColumns"
                                        class="px-2 {{ $loop->last ? 'mb-0' : 'mb-1' }}"
                                    >
                                        <input
                                            wire:model="selectedColumns"
                                            wire:target="selectedColumns"
                                            wire:loading.attr="disabled"
                                            type="checkbox"
                                            value="{{ $column->getHash() }}"
                                        />
                                        <span class="ml-2">{{ $column->getTitle() }}</span>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($component->paginationIsEnabled() && $component->perPageVisibilityIsEnabled())
            <div class="ms-0 ms-md-2">
                <select
                    wire:model="perPage"
                    id="perPage"
                    class="form-control"
                >
                    @foreach ($component->getPerPageAccepted() as $item)
                        <option value="{{ $item }}" wire:key="per-page-{{ $item }}-{{ $component->getTableName() }}">{{ $item === -1 ? __('All') : $item }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
</div>

@if ($component->filtersAreEnabled() && $component->filtersVisibilityIsEnabled() && $component->hasFilters() && $component->isFilterLayoutSlideDown())
    <div
        x-cloak
        x-show="filtersOpen"
    >
        <div class="container">
            <div class="row">
                @foreach($component->getFilters() as $filter)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <label for="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
                            class="d-block">
                            {{ $filter->getName() }}
                        </label>

                        {{ $filter->render($component) }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
