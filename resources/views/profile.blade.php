<x-app-layout>

    <x-slot name="style">
        @vite(['resources/scss/profile.scss'])
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('profile'))
                {{ __('Perfil') }}
            @else
                <a href="{{ route('profile') }}">{{ __('Perfil') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:profile.update-profile-information-form />
        </div>

        <div class="actions p-3">
            <livewire:profile.update-password-form />
        </div>

        <div class="actions p-3 mb-3">
            <livewire:profile.delete-user-form />
        </div>
    </div>
</x-app-layout>
