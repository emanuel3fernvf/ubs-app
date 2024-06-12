<div>
    <div class="mb-3">
        <x-primary-button type="button"
            wire:click="$dispatch('professional-new')">
            <i class="fa-solid fa-plus"></i>
            Novo profissional
        </x-primary-button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">CRM</th>
                <th scope="col">Especialidade</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professionals as $professional)
                <tr>
                    <td>{{ $professional->id }}</td>
                    <td>{{ $professional->name }}</td>
                    <td>{{ $professional->crm }}</td>
                    <td>{{ $professional->specialty_name }}</td>
                    <td>{{ $professional->status }}</td>
                    <td class="text-center">
                        <div class="dropstart">
                            <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </button>

                            <div class="dropdown-menu pt-2 px-2">

                                <x-primary-button type="button"
                                    class="btn-sm mb-2"
                                    wire:click="$dispatch('professional-edit', { professionalId: {{ $professional->id }} })">
                                    <i class="fa-solid fa-pencil-alt"></i>
                                    Editar
                                </x-primary-button>

                                <x-danger-button type="button"
                                    class="btn-sm mb-2"
                                    wire:click="confirm('delete', {{ $professional->id }})">
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
        {{ $professionals->links() }}
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
