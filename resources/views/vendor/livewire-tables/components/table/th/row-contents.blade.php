@aware(['component'])

@if ($component->collapsingColumnsAreEnabled() && $component->hasCollapsedColumns())
    @php
        $theme = $component->getTheme();
    @endphp


        <th
            scope="col"
            {{
                $attributes
                    ->merge(['class' => 'd-table-cell'])
                    ->class([
                        'd-md-none' =>
                            (($component->shouldCollapseOnMobile() && $component->shouldCollapseOnTablet()) ||
                            ($component->shouldCollapseOnTablet() && ! $component->shouldCollapseOnMobile()))
                    ])
                    ->class(['d-sm-none' => $component->shouldCollapseOnMobile() && ! $component->shouldCollapseOnTablet()])
            }}
        ></th>
@endif
