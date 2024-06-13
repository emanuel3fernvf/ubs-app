<div>
    <div
        class="modal fade" id="address-form-modal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" wire:ignore.self
        aria-labelledby="addressFormModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addressFormModalLabel">
                        @if ($this->addressId)
                            @if (true)
                                Editar endereço
                            @else
                                Ver endereço
                            @endif
                        @else
                            Novo endereço
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-row mt-3 px-3">

                            <div class="col-12 mb-3">
                                <x-input-label for="city" :value="__('Cidade:')" />
                                <x-text-input wire:model="city" id="city" name="city" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="street" :value="__('Rua:')" />
                                <x-text-input wire:model="street" id="street" name="street" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('street')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="number" :value="__('Número:')" />
                                <x-text-input wire:model="number" id="number" name="number" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('number')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="neighborhood" :value="__('Bairro:')" />
                                <x-text-input wire:model="neighborhood" id="neighborhood" name="neighborhood" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('neighborhood')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="complement" :value="__('Complemento:')" />
                                <x-text-input wire:model="complement" id="complement" name="complement" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('complement')" />
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <x-danger-button type="button" data-bs-dismiss="modal">
                        Fechar
                    </x-danger-button>

                    @if (!$this->addressId)
                        <x-primary-button type="button" wire:click="submit">
                            Salvar
                        </x-primary-button>
                    @endif

                    @if (true && $this->addressId)
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
