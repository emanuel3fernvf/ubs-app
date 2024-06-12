<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.professionalFormModalEl = document.getElementById('professional-form-modal');
                window.professionalFormModal = new bootstrap.Modal(professionalFormModalEl);

                window.addEventListener('close-professional-form-modal', event => {
                    professionalFormModal.hide();
                });

                window.addEventListener('open-professional-form-modal', event => {
                    professionalFormModal.show();
                });

                professionalFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('professional-list-render');
                })

            }, { once: true });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.professional'))
                {{ __('Profissionais') }}
            @else
                <a href="{{ route('dashboard.professional') }}">{{ __('Profissionais') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:professional.professional-list />
        </div>

        <livewire:professional.professional-form />
    </div>
</x-app-layout>
