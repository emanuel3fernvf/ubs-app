<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.scheduleFormModalEl = document.getElementById('schedule-form-modal');
                window.scheduleFormModal = new bootstrap.Modal(scheduleFormModalEl);

                window.addEventListener('close-schedule-form-modal', event => {
                    scheduleFormModal.hide();
                });

                window.addEventListener('open-schedule-form-modal', event => {
                    scheduleFormModal.show();
                });

                scheduleFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('schedule-list-render');
                })

            }, { once: true });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.schedule'))
                {{ __('Agendamentos') }}
            @else
                <a href="{{ route('dashboard.schedule') }}">{{ __('Agendamentos') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:schedule.schedule-list />
        </div>

        <livewire:schedule.schedule-form />
    </div>
</x-app-layout>
