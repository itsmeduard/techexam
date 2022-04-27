@aware(['component'])

@php
    $theme = $component->getTheme();

    $customAttributes = [
        'wrapper' => $this->getTableWrapperAttributes(),
        'table' => $this->getTableAttributes(),
        'thead' => $this->getTheadAttributes(),
        'tbody' => $this->getTbodyAttributes(),
    ];
@endphp

<div {{
    $attributes->merge($customAttributes['wrapper'])
        ->class(['table-responsive' => $customAttributes['wrapper']['default'] ?? true])
        ->except('default')
}}>
    <table {{
        $attributes->merge($customAttributes['table'])
            ->class(['table table-striped' => $customAttributes['table']['default'] ?? true])
            ->except('default')
    }}>
        <thead {{
            $attributes->merge($customAttributes['thead'])
                ->class(['' => $customAttributes['thead']['default'] ?? true])
                ->except('default')
        }}>
            <tr>
                {{ $thead }}
            </tr>
        </thead>

        <tbody
            @if ($component->reorderIsEnabled())
                wire:sortable="{{ $component->getReorderMethod() }}"
            @endif

            {{
                $attributes->merge($customAttributes['tbody'])
                    ->class(['' => $customAttributes['tbody']['default'] ?? true])
                    ->except('default')
            }}
        >
            {{ $slot }}
        </tbody>

        @if (isset($tfoot))
            <tfoot>
                {{ $tfoot }}
            </tfoot>
        @endif
    </table>
</div>
