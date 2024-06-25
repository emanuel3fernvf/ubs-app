<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.userFormModalEl = document.getElementById('user-form-modal');
                window.userFormModal = new bootstrap.Modal(userFormModalEl);

                window.addEventListener('close-user-form-modal', event => {
                    userFormModal.hide();
                });

                window.addEventListener('open-user-form-modal', event => {
                    userFormModal.show();
                });

                userFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('user-list-render');
                })

            }, { once: true });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.user'))
                {{ __('Usuários') }}
            @else
                <a href="{{ route('dashboard.user') }}">{{ __('Usuários') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:user.user-list />
        </div>

        <livewire:user.user-form />
    </div>
</x-app-layout>
