<div>
    <div
        class="modal fade" id="schedule-form-modal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" wire:ignore.self
        aria-labelledby="scheduleFormModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <form class="modal-content" wire:submit.prevent="submit">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="scheduleFormModalLabel">
                        @if ($this->scheduleId)
                            @if (true)
                                Editar agendamento
                            @else
                                Ver agendamento
                            @endif
                        @else
                            Novo agendamento
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3 px-3">

                        <div class="col-12 mb-3">
                            <x-input-label for="professional_id" :value="__('Profissional:')" />
                            <x-select-input wire:model="professional_id" id="professional_id" name="professional_id" required>
                                <option value="">Selecione</option>
                                @foreach ($professionals as $professional)
                                    <option value="{{ $professional->id }}">{{ $professional->name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('professional_id')" />
                        </div>

                        <div class="col-12 mb-3">
                            <x-input-label for="patient_id" :value="__('Paciente:')" />
                            <x-select-input wire:model="patient_id" id="patient_id" name="patient_id" required>
                                <option value="">Selecione</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('patient_id')" />
                        </div>

                        <div class="col-12 mb-3">
                            <x-input-label for="date" :value="__('Data:')" />
                            <x-text-input wire:model="date" id="date" name="date" type="date" required autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('date')" />
                        </div>

                        <div class="col-12 mb-3">
                            <x-input-label for="time" :value="__('Hora:')" />
                            <x-text-input wire:model="time" id="time" name="time" type="time" required autocomplete="off" min="07:00" max="17:00" />
                            <x-input-error class="mt-2" :messages="$errors->get('time')" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <x-danger-button type="button" data-bs-dismiss="modal">
                        Fechar
                    </x-danger-button>

                    @if (!$this->scheduleId)
                        <x-primary-button>
                            Salvar
                        </x-primary-button>
                    @endif

                    @if (true && $this->scheduleId)
                        <x-primary-button>
                            Atualizar
                        </x-primary-button>
                    @endif
                </div>
            </form>
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
