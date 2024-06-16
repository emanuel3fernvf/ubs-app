<div>
    <div
        class="modal fade" id="unit-form-modal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" wire:ignore.self
        aria-labelledby="unitFormModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="unitFormModalLabel">
                        @if ($this->unitId)
                            @if (true)
                                Editar unidade
                            @else
                                Ver unidade
                            @endif
                        @else
                            Nova unidade
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-row mt-3 px-3">

                            <div class="col-12 mb-3">
                                <x-input-label for="name" :value="__('Nome:')" />
                                <x-text-input wire:model="name" id="name" name="name" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="status" :value="__('Status:')" />
                                <x-select-input wire:model="status" id="status" name="status" required>
                                    <option value="">Selecione</option>
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <x-danger-button type="button" data-bs-dismiss="modal">
                        Fechar
                    </x-danger-button>

                    @if (!$this->unitId)
                        <x-primary-button type="button" wire:click="submit">
                            Salvar
                        </x-primary-button>
                    @endif

                    @if (true && $this->unitId)
                        <x-primary-button type="button" wire:click="submit">
                            Atualizar
                        </x-primary-button>
                    @endif
                </div>
            </div>
        </div>

    </div>

    @teleport('#general-response-modal .modal-footer')
        <div wire:ignore.self>
            @if (in_array($this->responseType,['information', 'error']))
                <x-primary-button data-bs-dismiss="modal">
                    Ok
                </x-primary-button>
            @endif
        </div>
    @endteleport
</div>
