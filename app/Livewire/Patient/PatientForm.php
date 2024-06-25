<?php

namespace App\Livewire\Patient;

use App\Helpers\Helper;
use App\Http\Requests\Patient\PatientCreateRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;
use App\Services\Patient\PatientService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PatientForm extends Component
{
    public $patientId;

    public $name;

    public $cpf;

    public $birth_date;

    public $phone;

    public $status;

    public $responseType;

    const PERMISSION_KEY = 'patient';

    const PER_PAGE = 10;

    public function render()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'read');
        if (! $permission) {
            return view('components.unauthorized');
        }

        return view('livewire.patient.patient-form');
    }

    public function submit()
    {
        if (! $this->patientId) {
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

        $service = new PatientService(Auth::user());
        $service->permission = $permission;

        $request = new PatientCreateRequest();

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

        $this->dispatch('close-patient-form-modal');

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

        $service = new PatientService(Auth::user());
        $service->permission = $permission;

        $request = new PatientUpdateRequest();

        $validated = $this->validate(
            $request->rules(),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->patientId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-patient-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('patient-new')]
    public function new()
    {
        $permission = 'create';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-patient-form-modal');
    }

    #[On('patient-edit')]
    public function edit(int $patientId)
    {
        $permission = 'edit';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new PatientService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($patientId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $patient = $response['data']['patient'];

        $this->patientId = $patientId;

        $this->name = $patient->name;
        $this->cpf = $patient->cpf;
        $this->birth_date = $patient->birth_date->format('Y-m-d');
        $this->phone = $patient->phone;
        $this->status = $patient->status;

        return $this->dispatch('open-patient-form-modal');
    }
}
