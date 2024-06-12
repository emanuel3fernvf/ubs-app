<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.specialtyFormModalEl = document.getElementById('specialty-form-modal');
                window.specialtyFormModal = new bootstrap.Modal(specialtyFormModalEl);

                window.addEventListener('close-specialty-form-modal', event => {
                    specialtyFormModal.hide();
                });

                window.addEventListener('open-specialty-form-modal', event => {
                    specialtyFormModal.show();
                });

                specialtyFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('specialty-list-render');
                })

            }, { once: true });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.specialty'))
                {{ __('Especialidades') }}
            @else
                <a href="{{ route('dashboard.specialty') }}">{{ __('Especialidades') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:specialty.specialty-list />
        </div>

        <livewire:specialty.specialty-form />
    </div>
</x-app-layout>
