<?php

namespace App\Livewire\User;

use App\Helpers\Helper;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $userId;

    public $responseType;

    const PERMISSION_KEY = 'user';

    const PER_PAGE = 10;

    #[On('user-list-render')]
    public function render()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'read');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new UserService(Auth::user());
        $users = $service->listWithPagination([], self::PER_PAGE);

        return view('livewire.user.user-list', compact('users'));
    }

    public function confirm(string $action, int $userId)
    {
        $this->userId = $userId;

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

        $service = new UserService(Auth::user());
        $service->permission = $permission;

        $response = $service->delete(intval($this->userId), $confirmation);

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
