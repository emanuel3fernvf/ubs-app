<?php

namespace App\Livewire\Schedule;

use App\Helpers\Helper;
use App\Http\Requests\Schedule\ScheduleCreateRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Services\Schedule\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ScheduleForm extends Component
{
    public $scheduleId;

    public $professional_id;

    public $patient_id;

    public $date;

    public $time;

    public $responseType;

    const PERMISSION_KEY = 'schedule';

    const PER_PAGE = 10;

    public function render()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'read');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new ScheduleService(Auth::user());
        $service->permission = $permission;

        $response = $service->formData();

        if (! $response['success']) {
            return view('components.error', [
                'message' => $response['message'],
            ]);
        }

        return view('livewire.schedule.schedule-form', $response['data']);
    }

    public function submit()
    {
        if (! $this->scheduleId) {
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

        $service = new ScheduleService(Auth::user());
        $service->permission = $permission;

        $response = $service->formData();

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $professional_id = $response['data']['professionals']->pluck('id')->toArray();
        $patient_id = $response['data']['patients']->pluck('id')->toArray();

        $request = new ScheduleCreateRequest();

        $validated = $this->validate(
            $request->rules(compact('professional_id', 'patient_id')),
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

        $this->dispatch('close-schedule-form-modal');

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

        $service = new ScheduleService(Auth::user());
        $service->permission = $permission;

        $response = $service->formData();

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $professional_id = $response['data']['professionals']->pluck('id')->toArray();
        $patient_id = $response['data']['patients']->pluck('id')->toArray();

        $request = new ScheduleUpdateRequest();

        $validated = $this->validate(
            $request->rules(compact('professional_id', 'patient_id')),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->scheduleId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-schedule-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('schedule-new')]
    public function new()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-schedule-form-modal');
    }

    #[On('schedule-edit')]
    public function edit(int $scheduleId)
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new ScheduleService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($scheduleId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $schedule = $response['data']['schedule'];

        $this->scheduleId = $scheduleId;

        $this->patient_id = $schedule->patient_id;
        $this->professional_id = $schedule->professional_id;
        $this->date = $schedule->date->format('Y-m-d');
        $this->time = $schedule->date->format('H:i');

        return $this->dispatch('open-schedule-form-modal');
    }
}
