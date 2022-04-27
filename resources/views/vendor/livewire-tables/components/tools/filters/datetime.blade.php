@php
    $theme = $component->getTheme();
@endphp
<div class="mb-3 mb-md-0 input-group">
    <input
        wire:model.stop="{{ $component->getTableName() }}.filters.{{ $filter->getKey() }}"
        wire:key="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
        id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
        type="datetime-local"
        @if($filter->hasConfig('min')) min="{{ $filter->getConfig('min') }}" @endif
        @if($filter->hasConfig('max')) max="{{ $filter->getConfig('max') }}" @endif
        class="form-control"
    />
</div>