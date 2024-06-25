<?php

namespace App\Livewire\User;

use App\Helpers\Helper;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UserForm extends Component
{
    public $userId;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public int $position_id;

    public string $status;

    public string $responseType = '';

    const PERMISSION_KEY = 'user';

    const PER_PAGE = 10;

    public function render()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'read');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $service = new UserService(Auth::user());

        $positions = $service->positions();

        return view('livewire.user.user-form', compact(
            'positions',
        ));
    }

    public function submit()
    {
        if (! $this->userId) {
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

        $service = new UserService(Auth::user());
        $service->permission = $permission;

        $positions = $service->positions()->pluck('id')->toArray();

        $request = new UserCreateRequest();

        $validated = $this->validate(
            $request->rules($positions),
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

        $this->dispatch('close-user-form-modal');

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

        $service = new UserService(Auth::user());
        $service->permission = $permission;

        $request = new UserUpdateRequest();

        $positions = $service->positions()->pluck('id')->toArray();

        $validated = $this->validate(
            $request->rules($this->userId, $positions),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->userId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-user-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('user-new')]
    public function new()
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-user-form-modal');
    }

    #[On('user-edit')]
    public function edit(int $userId)
    {
        $permission = Helper::checkPermission(self::PERMISSION_KEY, 'write');
        if (! $permission) {
            return view('components.unauthorized');
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new UserService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($userId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $user = $response['data']['user'];

        $this->userId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->position_id = $user->position_id;
        $this->status = $user->status;

        return $this->dispatch('open-user-form-modal');
    }
}
