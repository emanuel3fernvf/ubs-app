<?php

namespace App\Livewire\Patient;

use App\Services\Patient\PatientService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PatientList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $patientId;

    public $responseType;

    const PERMISSION_KEY = 'patient';

    const PER_PAGE = 10;

    #[On('patient-list-render')]
    public function render()
    {
        $permission = 'permission';

        $service = new PatientService(Auth::user());
        $patients = $service->listWithPagination([], self::PER_PAGE);

        return view('livewire.patient.patient-list', [
            'patients' => $patients,
        ]);
    }

    public function confirm(string $action, int $patientId)
    {
        $this->patientId = $patientId;

        if ($action == 'delete') {
            return $this->delete();
        }
    }

    public function delete(bool $confirmation = false)
    {
        $permission = 'patient';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $service = new PatientService(Auth::user());
        $service->permission = $permission;

        $response = $service->delete(intval($this->patientId), $confirmation);

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
