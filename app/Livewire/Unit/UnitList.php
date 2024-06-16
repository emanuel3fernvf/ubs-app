<?php

namespace App\Livewire\Unit;

use App\Services\Unit\UnitService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UnitList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $unitId;

    public $responseType;

    const PERMISSION_KEY = 'unit';

    const PER_PAGE = 10;

    #[On('unit-list-render')]
    public function render()
    {
        $permission = 'permission';

        $service = new UnitService(Auth::user());
        $units = $service->listWithPagination([], self::PER_PAGE);

        return view('livewire.unit.unit-list', compact('units'));
    }

    public function confirm(string $action, int $unitId)
    {
        $this->unitId = $unitId;

        if ($action == 'delete') {
            return $this->delete();
        }
    }

    public function delete(bool $confirmation = false)
    {
        $permission = 'unit';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $service = new UnitService(Auth::user());
        $service->permission = $permission;

        $response = $service->delete(intval($this->unitId), $confirmation);

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
