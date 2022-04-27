@aware(['component'])

@php
    $theme = $component->getTheme();
@endphp
<div>
    @if ($component->sortingPillsAreEnabled() && $component->hasSorts())
        <div class="mb-3">
            <small>@lang('Applied Sorting'):</small>

            @foreach($component->getSorts() as $columnSelectName => $direction)
                @php
                    $column = $component->getColumnBySelectName($columnSelectName);
                @endphp

                @continue(is_null($column))
                @continue($column->isHidden())
                @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))

                <span
                    wire:key="sorting-pill-{{ $columnSelectName }}"
                    class="badge rounded-pill bg-info d-inline-flex align-items-center"
                >
                    {{ $column->getSortingPillTitle() }}: {{ $column->getSortingPillDirection($component, $direction) }}

                    <a
                        href="#"
                        wire:click="clearSort('{{ $columnSelectName }}')"
                        class="text-white ms-2"
                    >
                        <span class="visually-hidden">@lang('Remove sort option')</span>
                        <svg style="width:.5em;height:.5em" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </a>
                </span>
            @endforeach

            <a
                href="#"
                wire:click.prevent="clearSorts"
                class="badge rounded-pill bg-light text-dark text-decoration-none"
            >
                @lang('Clear')
            </a>
        </div>
    @endif
</div>
