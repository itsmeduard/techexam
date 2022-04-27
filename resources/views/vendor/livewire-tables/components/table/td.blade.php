@aware(['component', 'row', 'rowIndex'])
@props(['column', 'colIndex'])

@php
    $attributes = $attributes->merge(['wire:key' => 'cell-'.$rowIndex.'-'.$colIndex.'-'.$component->id]);
    $theme = $component->getTheme();
    $customAttributes = $component->getTdAttributes($column, $row, $colIndex, $rowIndex)
@endphp

    <td {{
        $attributes->merge($customAttributes)
            ->class(['' => $customAttributes['default'] ?? true])
            ->class(['d-none d-sm-table-cell' => $column && $column->shouldCollapseOnMobile()])
            ->class(['d-none d-md-table-cell' => $column && $column->shouldCollapseOnTablet()])
            ->except('default')
    }}>{{ $slot }}</td>
