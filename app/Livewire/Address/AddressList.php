<?php

namespace App\Livewire\Address;

use App\Helpers\Helper;
use App\Services\Address\AddressService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AddressList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $addressId;

    public $responseType;

    const PERMISSION_KEY = 'address';

    const PER_PAGE = 10;

    #[On('address-list-render')]
    public function render()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'read');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new AddressService(Auth::user());
        $addresses = $service->listWithPagination([], self::PER_PAGE);

        return view('livewire.address.address-list', compact('addresses'));
    }

    public function confirm(string $action, int $addressId)
    {
        $this->addressId = $addressId;

        if ($action == 'delete') {
            return $this->delete();
        }
    }

    public function delete(bool $confirmation = false)
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new AddressService(Auth::user());
        $service->permission = $permission;

        $response = $service->delete(intval($this->addressId), $confirmation);

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
