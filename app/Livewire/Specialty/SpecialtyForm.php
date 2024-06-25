<?php

namespace App\Livewire\Specialty;

use App\Helpers\Helper;
use App\Http\Requests\Specialty\SpecialtyCreateRequest;
use App\Http\Requests\Specialty\SpecialtyUpdateRequest;
use App\Services\Specialty\SpecialtyService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class SpecialtyForm extends Component
{
    public $specialtyId;

    public $name;

    public $status;

    public $responseType;

    const PERMISSION_KEY = 'specialty';

    const PER_PAGE = 10;

    public function render()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'read');
        if (! $permission) {
            return view('components.unauthorized');
        }

        return view('livewire.specialty.specialty-form');
    }

    public function submit()
    {
        if (! $this->specialtyId) {
            return $this->save();
        }

        return $this->update();
    }

    public function save()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new SpecialtyService(Auth::user());
        $service->permission = $permission;

        $request = new SpecialtyCreateRequest();

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

        $this->dispatch('close-specialty-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    private function update()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new SpecialtyService(Auth::user());
        $service->permission = $permission;

        $request = new SpecialtyUpdateRequest();

        $validated = $this->validate(
            $request->rules(),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->specialtyId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-specialty-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('specialty-new')]
    public function new()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-specialty-form-modal');
    }

    #[On('specialty-edit')]
    public function edit(int $specialtyId)
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new SpecialtyService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($specialtyId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $specialty = $response['data']['specialty'];

        $this->specialtyId = $specialtyId;

        $this->name = $specialty->name;
        $this->status = $specialty->status;

        return $this->dispatch('open-specialty-form-modal');
    }
}
