@php
    $theme = $component->getTheme();
@endphp
<select
    wire:model.stop="{{ $component->getTableName() }}.filters.{{ $filter->getKey() }}"
    wire:key="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
    id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
    class="form-control"
>
    @foreach($filter->getOptions() as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
