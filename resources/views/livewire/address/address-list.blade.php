<div>
    <div class="mb-3">
        <x-primary-button type="button"
            wire:click="$dispatch('address-new')">
            <i class="fa-solid fa-plus"></i>
            Novo endereço
        </x-primary-button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($addresses as $address)
                <tr>
                    <td>{{ $address->id }}</td>
                    <td>{{ $address->name }}</td>
                    <td>{{ __('texts.values.'.$address->status) }}</td>
                    <td class="text-center">
                        <div class="dropstart">
                            <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </button>

                            <div class="dropdown-menu pt-2 px-2">

                                <x-primary-button type="button"
                                    class="btn-sm mb-2"
                                    wire:click="$dispatch('address-edit', { addressId: {{ $address->id }} })">
                                    <i class="fa-solid fa-pencil-alt"></i>
                                    Editar
                                </x-primary-button>

                                <x-danger-button type="button"
                                    class="btn-sm mb-2"
                                    wire:click="confirm('delete', {{ $address->id }})">
                                    <i class="fa-solid fa-trash"></i> Remover
                                </x-danger-button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $addresses->links() }}
    </div>

    @teleport('#general-response-modal .modal-footer')
        <div wire:ignore.self>
            @if (in_array($this->responseType,['information', 'error']))
                <x-primary-button data-bs-dismiss="modal">
                    Ok
                </x-primary-button>
            @endif

            @if ($this->responseType == 'confirmation-delete')
                <x-primary-button data-bs-dismiss="modal">
                    Não
                </x-primary-button>

                <x-danger-button
                    wire:click="delete(true)">
                    Sim
                </x-danger-button>
            @endif
        </div>
    @endteleport

</div>
