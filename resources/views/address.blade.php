<x-app-layout>

    <x-slot name="js">
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {

                window.addressFormModalEl = document.getElementById('address-form-modal');
                window.addressFormModal = new bootstrap.Modal(addressFormModalEl);

                window.addEventListener('close-address-form-modal', event => {
                    addressFormModal.hide();
                });

                window.addEventListener('open-address-form-modal', event => {
                    addressFormModal.show();
                });

                addressFormModalEl.addEventListener('hidden.bs.modal', event => {
                    Livewire.dispatch('address-list-render');
                })

            }, { once: true });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="breadcrumb-item">
            @if(request()->routeIs('dashboard.address'))
                {{ __('Endereços') }}
            @else
                <a href="{{ route('dashboard.address') }}">{{ __('Endereços') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="d-flex flex-column gap-3">
        <div class="actions p-3">
            <livewire:address.address-list />
        </div>

        <livewire:address.address-form />
    </div>
</x-app-layout>
