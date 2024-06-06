<x-app-newp-layout>

    <x-slot name="style">
        @vite(['resources/scss/profile.scss'])
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.patient'))
                {{ __('Pacientes') }}
            @else
                <a href="{{ route('dashboard.patient') }}">{{ __('Pacientes') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:patient.patient-list />
        </div>
    </div>
</x-app-newp-layout>
