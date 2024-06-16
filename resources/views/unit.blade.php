<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.unitFormModalEl = document.getElementById('unit-form-modal');
                window.unitFormModal = new bootstrap.Modal(unitFormModalEl);

                window.addEventListener('close-unit-form-modal', event => {
                    unitFormModal.hide();
                });

                window.addEventListener('open-unit-form-modal', event => {
                    unitFormModal.show();
                });

                unitFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('unit-list-render');
                })

            }, { once: true });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.unit'))
                {{ __('Unidades') }}
            @else
                <a href="{{ route('dashboard.unit') }}">{{ __('Unidades') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:unit.unit-list />
        </div>

        <livewire:unit.unit-form />
    </div>
</x-app-layout>
