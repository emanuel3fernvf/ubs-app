<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.patientFormModalEl = document.getElementById('patient-form-modal');
                window.patientFormModal = new bootstrap.Modal(patientFormModalEl);

                window.addEventListener('close-patient-form-modal', event => {
                    patientFormModal.hide();
                });

                window.addEventListener('open-patient-form-modal', event => {
                    patientFormModal.show();
                });

                patientFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('patient-list-render');
                })

            }, { once: true });
        </script>
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

        <livewire:patient.patient-form />
    </div>
</x-app-layout>
