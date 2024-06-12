<?php

namespace App\Livewire\Professional;

use App\Http\Requests\Professional\ProfessionalCreateRequest;
use App\Http\Requests\Professional\ProfessionalUpdateRequest;
use App\Services\Professional\ProfessionalService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfessionalForm extends Component
{
    public $professionalId;

    public $crm;

    public $user_id;

    public $specialty_id;

    public $status;

    public $responseType;

    const PERMISSION_KEY = 'professional';

    const PER_PAGE = 10;

    public function render()
    {
        $permission = self::PERMISSION_KEY;

        $service = new ProfessionalService(Auth::user());

        $users = $service->users($this->professionalId);
        $specialties = $service->specialties();

        return view('livewire.professional.professional-form', compact(
            'users',
            'specialties',
        ));
    }

    public function submit()
    {
        if (! $this->professionalId) {
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

        $service = new ProfessionalService(Auth::user());
        $service->permission = $permission;

        $users = $service->users($this->professionalId)->pluck('id')->toArray();
        $specialties = $service->specialties()->pluck('id')->toArray();

        $request = new ProfessionalCreateRequest();

        $validated = $this->validate(
            $request->rules($users, $specialties),
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

        $this->dispatch('close-professional-form-modal');

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

        $service = new ProfessionalService(Auth::user());
        $service->permission = $permission;

        $request = new ProfessionalUpdateRequest();

        $users = $service->users($this->professionalId)->pluck('id')->toArray();
        $specialties = $service->specialties()->pluck('id')->toArray();

        $validated = $this->validate(
            $request->rules($users, $specialties),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->professionalId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-professional-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('professional-new')]
    public function new()
    {
        $permission = 'create';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-professional-form-modal');
    }

    #[On('professional-edit')]
    public function edit(int $professionalId)
    {
        $permission = 'edit';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new ProfessionalService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($professionalId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $professional = $response['data']['professional'];

        $this->professionalId = $professionalId;

        $this->crm = $professional->crm;
        $this->user_id = $professional->user_id;
        $this->specialty_id = $professional->specialty_id;
        $this->status = $professional->status;

        return $this->dispatch('open-professional-form-modal');
    }
}
