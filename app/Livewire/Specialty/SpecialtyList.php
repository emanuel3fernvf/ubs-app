<?php

namespace App\Livewire\Specialty;

use App\Services\Specialty\SpecialtyService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SpecialtyList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $specialtyId;

    public $responseType;

    const PERMISSION_KEY = 'specialty';

    const PER_PAGE = 10;

    #[On('specialty-list-render')]
    public function render()
    {
        $permission = 'permission';

        $service = new SpecialtyService(Auth::user());
        $specialties = $service->listWithPagination([], self::PER_PAGE);

        return view('livewire.specialty.specialty-list', compact('specialties'));
    }

    public function confirm(string $action, int $specialtyId)
    {
        $this->specialtyId = $specialtyId;

        if ($action == 'delete') {
            return $this->delete();
        }
    }

    public function delete(bool $confirmation = false)
    {
        $permission = 'specialty';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $service = new SpecialtyService(Auth::user());
        $service->permission = $permission;

        $response = $service->delete(intval($this->specialtyId), $confirmation);

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
