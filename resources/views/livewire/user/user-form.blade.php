<div>
    <div
        class="modal fade" id="user-form-modal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" wire:ignore.self
        aria-labelledby="userFormModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userFormModalLabel">
                        @if ($this->userId)
                            @if (true)
                                Editar usuário
                            @else
                                Ver usuário
                            @endif
                        @else
                            Novo usuário
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-row mt-3 px-3">
                            <div class="col-12 mb-3">
                                <x-input-label for="name" :value="__('Nome:')" />
                                <x-text-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="email" :value="__('Email:')" />
                                <x-text-input wire:model="email" id="email" type="email" name="email" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="password" :value="__('Senha:')" />

                                <x-text-input wire:model="password" id="password"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="password_confirmation" :value="__('Confirme sua senha:')" />

                                <x-text-input wire:model="password_confirmation" id="password_confirmation"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="position_id" :value="__('Cargo:')" />
                                <x-select-input wire:model.live="position_id" id="position_id" name="position_id" required>
                                    <option value="">Selecione</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('position_id')" />
                            </div>

                            <div class="col-12 mb-3">
                                <x-input-label for="status" :value="__('Status:')" />
                                <x-select-input wire:model.live="status" id="status" name="status" required>
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

                    @if (!$this->userId)
                        <x-primary-button type="button" wire:click="submit">
                            Salvar
                        </x-primary-button>
                    @endif

                    @if (true && $this->userId)
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
