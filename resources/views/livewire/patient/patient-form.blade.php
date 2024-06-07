<div>
    <div
        class="modal fade" id="patient-form-modal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" wire:ignore.self
        aria-labelledby="patientFormModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="patientFormModalLabel">
                        @if ($this->patientId)
                            @if (true)
                                Editar paciente
                            @else
                                Ver paciente
                            @endif
                        @else
                            Novo paciente
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
                                <x-input-label for="cpf" :value="__('Cpf:')" />
                                <x-text-input wire:model="cpf" id="cpf" name="cpf" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="birth_date" :value="__('Data de nascimento:')" />
                                <x-text-input wire:model="birth_date" id="birth_date" name="birth_date" type="date" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="phone" :value="__('Telefone:')" />
                                <x-text-input wire:model="phone" id="phone" name="phone" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
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

                            <div class="col-12 mb-3">
                                <x-input-label for="address_street" :value="__('Rua:')" />
                                <x-text-input wire:model="address_street" id="address_street" name="address_street" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('address_street')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="address_number" :value="__('Número:')" />
                                <x-text-input wire:model="address_number" id="address_number" name="address_number" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('address_number')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="address_complement" :value="__('Complemento:')" />
                                <x-text-input wire:model="address_complement" id="address_complement" name="address_complement" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('address_complement')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="address_neighborhood" :value="__('Bairro:')" />
                                <x-text-input wire:model="address_neighborhood" id="address_neighborhood" name="address_neighborhood" type="text" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('address_neighborhood')" />
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <x-danger-button type="button" data-bs-dismiss="modal">
                        Fechar
                    </x-danger-button>

                    @if (!$this->patientId)
                        <x-primary-button type="button" wire:click="submit">
                            Salvar
                        </x-primary-button>
                    @endif

                    @if (true && $this->patientId)
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
