@aware(['component'])
@props(['row', 'rowIndex'])

@if ($component->collapsingColumnsAreEnabled() && $component->hasCollapsedColumns())
    @php
        $theme = $component->getTheme();
        $columns = collect([]);

        if ($component->shouldCollapseOnMobile() && $component->shouldCollapseOnTablet()) {
            $columns->push($component->getCollapsedMobileColumns());
            $columns->push($component->getCollapsedTabletColumns());
        } elseif ($component->shouldCollapseOnTablet() && ! $component->shouldCollapseOnMobile()) {
            $columns->push($component->getCollapsedTabletColumns());
        } elseif ($component->shouldCollapseOnMobile() && ! $component->shouldCollapseOnTablet()) {
            $columns->push($component->getCollapsedMobileColumns());
        }

        $columns = $columns->collapse();

        // TODO: Column count
        $colspan = $columns->count() + 1;
    @endphp


        <tr
            wire:key="row-{{ $rowIndex }}-collapsed-contents"
            x-data
            @toggle-row-content.window="$event.detail.row === {{ $rowIndex }} ? $el.classList.toggle('d-none') : null"
            class="d-none d-md-none"
        >
            <td class="pt-3 p-2" colspan="{{ $colspan }}">
                <div>
                    @foreach($columns as $colIndex => $column)
                        @continue($column->isHidden())
                        @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))

                        <p class="d-block mb-2 @if($column->shouldCollapseOnMobile()) d-sm-none @endif @if($column->shouldCollapseOnTablet()) d-md-none @endif">
                            <strong>{{ $column->getTitle() }}</strong>: {{ $column->renderContents($row) }}
                        </p>
                    @endforeach
                </div>
            </td>
        </tr>
    @endif

