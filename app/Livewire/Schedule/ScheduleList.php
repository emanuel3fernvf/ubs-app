<?php

namespace App\Livewire\Schedule;

use App\Services\Schedule\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $scheduleId;

    public $responseType;

    const PERMISSION_KEY = 'schedule';

    const PER_PAGE = 10;

    #[On('schedule-list-render')]
    public function render()
    {
        $permission = 'permission';

        $service = new ScheduleService(Auth::user());
        $schedules = $service->listWithPagination([], self::PER_PAGE);

        return view('livewire.schedule.schedule-list', compact('schedules'));
    }

    public function confirm(string $action, int $scheduleId)
    {
        $this->scheduleId = $scheduleId;

        if ($action == 'delete') {
            return $this->delete();
        }
    }

    public function delete(bool $confirmation = false)
    {
        $permission = 'schedule';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $service = new ScheduleService(Auth::user());
        $service->permission = $permission;

        $response = $service->delete(intval($this->scheduleId), $confirmation);

        if ($response['success']) {
            $this->reset();

            $this->dispatch('close-general-response-modal');

            return $this->dispatch('toast',
                message: $response['message'],
                success: true,
            );
        }

        if ($response['type'] == 'confirmation') {
            $this->responseType = 'confirmation-delete';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Confirmação',
            );
        }

        if ($response['type'] == 'information') {
            $this->responseType = 'information';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Informação',
            );
        }

        $this->responseType = 'error';

        return $this->dispatch('general-response-modal',
            message: $response['message'],
            title: 'Erro',
        );
    }
}
