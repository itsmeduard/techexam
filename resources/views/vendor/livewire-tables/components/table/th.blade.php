@aware(['component'])
@props(['column', 'index'])

@php
    $attributes = $attributes->merge(['wire:key' => 'header-col-'.$index.'-'.$component->id]);
    $theme = $component->getTheme();
    $customAttributes = $component->getThAttributes($column);
    $direction = $column->hasField() ? $component->getSort($column->getColumnSelectName()) : null;
@endphp
    <th scope="col" {{
        $attributes->merge($customAttributes)
            ->class(['' => $customAttributes['default'] ?? true])
            ->class(['d-none d-sm-table-cell' => $column->shouldCollapseOnMobile()])
            ->class(['d-none d-md-table-cell' => $column->shouldCollapseOnTablet()])
            ->except('default')
    }}>
        @unless ($component->sortingIsEnabled() && $column->isSortable())
            {{ $column->getTitle() }}
        @else
            <div
                class="d-flex align-items-center"
                wire:click="sortBy('{{ $column->getColumnSelectName() }}')"
                style="cursor:pointer;"
            >
                <span>{{ $column->getTitle() }}</span>

                <span class="relative d-flex align-items-center">
                    @if ($direction === 'asc')
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" style="width:1em;height:1em;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    @elseif ($direction === 'desc')
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" style="width:1em;height:1em;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" style="width:1em;height:1em;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    @endif
                </span>
            </div>
        @endunless
    </th>
