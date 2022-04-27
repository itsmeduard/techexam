@aware(['component'])

@php
    $theme = $component->getTheme();
@endphp

<div>
    @if ($component->filtersAreEnabled() && $component->filterPillsAreEnabled() && $component->hasAppliedFiltersWithValues())
        <div class="mb-3">
            <small>@lang('Applied Filters'):</small>

            @foreach($component->getAppliedFiltersWithValues() as $filterSelectName => $value)
                @php
                    $filter = $component->getFilterByKey($filterSelectName);
                @endphp

                @continue(is_null($filter))

                <span
                    wire:key="{{ $component->getTableName() }}-filter-pill-{{ $filter->getKey() }}"
                    class="badge rounded-pill bg-info d-inline-flex align-items-center"
                >
                    {{ $filter->getFilterPillTitle() }}: {{ $filter->getFilterPillValue($value) }}

                    <a
                        href="#"
                        wire:click="resetFilter('{{ $filter->getKey() }}')"
                        class="text-white ms-2"
                    >
                        <span class="visually-hidden">@lang('Remove filter option')</span>
                        <svg style="width:.5em;height:.5em" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </a>
                </span>
            @endforeach

            <a
                href="#"
                wire:click.prevent="setFilterDefaults"
                class="badge rounded-pill bg-light text-dark text-decoration-none"
            >
                @lang('Clear')
            </a>
        </div>
    @endif
</div>
