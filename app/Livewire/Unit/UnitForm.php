<?php

namespace App\Livewire\Unit;

use App\Http\Requests\Unit\UnitCreateRequest;
use App\Http\Requests\Unit\UnitUpdateRequest;
use App\Services\Unit\UnitService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UnitForm extends Component
{
    public $unitId;

    public $name;

    public $status;

    public $responseType;

    const PERMISSION_KEY = 'unit';

    const PER_PAGE = 10;

    public function render()
    {
        return view('livewire.unit.unit-form');
    }

    public function submit()
    {
        if (! $this->unitId) {
            return $this->save();
        }

        return $this->update();
    }

    public function save()
    {
        $permission = 'save';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $service = new UnitService(Auth::user());
        $service->permission = $permission;

        $request = new UnitCreateRequest();

        $validated = $this->validate(
            $request->rules(),
            $request->messages()
        );

        $response = $service->create($validated);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-unit-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    private function update()
    {
        $permission = 'update';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $service = new UnitService(Auth::user());
        $service->permission = $permission;

        $request = new UnitUpdateRequest();

        $validated = $this->validate(
            $request->rules(),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->unitId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-unit-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('unit-new')]
    public function new()
    {
        $permission = 'create';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-unit-form-modal');
    }

    #[On('unit-edit')]
    public function edit(int $unitId)
    {
        $permission = 'edit';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new UnitService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($unitId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $unit = $response['data']['unit'];

        $this->unitId = $unitId;

        $this->name = $unit->name;
        $this->status = $unit->status;

        return $this->dispatch('open-unit-form-modal');
    }
}
