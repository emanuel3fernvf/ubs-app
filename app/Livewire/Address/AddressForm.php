<?php

namespace App\Livewire\Address;

use App\Http\Requests\Address\AddressCreateRequest;
use App\Http\Requests\Address\AddressUpdateRequest;
use App\Services\Address\AddressService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class AddressForm extends Component
{
    public $addressId;

    public $city;

    public $street;

    public $number;

    public $complement;

    public $neighborhood;

    public $responseType;

    const PERMISSION_KEY = 'address';

    const PER_PAGE = 10;

    public function render()
    {
        return view('livewire.address.address-form');
    }

    public function submit()
    {
        if (! $this->addressId) {
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

        $service = new AddressService(Auth::user());
        $service->permission = $permission;

        $request = new AddressCreateRequest();

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

        $this->dispatch('close-address-form-modal');

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

        $service = new AddressService(Auth::user());
        $service->permission = $permission;

        $request = new AddressUpdateRequest();

        $validated = $this->validate(
            $request->rules(),
            $request->messages()
        );

        $response = $service->update($validated, intval($this->addressId));

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $this->dispatch('close-address-form-modal');

        $this->reset();

        return $this->dispatch('toast',
            message: $response['message'],
            success: true,
        );
    }

    #[On('address-new')]
    public function new()
    {
        $permission = 'create';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        return $this->dispatch('open-address-form-modal');
    }

    #[On('address-edit')]
    public function edit(int $addressId)
    {
        $permission = 'edit';
        if (! $permission) {
            abort(403, __('messages.unauthorized'));
        }

        $this->reset();
        $this->resetErrorBag();

        $service = new AddressService(Auth::user());
        $service->permission = $permission;

        $response = $service->show($addressId);

        if (! $response['success']) {
            $this->responseType = 'error';

            return $this->dispatch('general-response-modal',
                message: $response['message'],
                title: 'Erro',
            );
        }

        $address = $response['data']['address'];

        $this->addressId = $addressId;

        $this->city = $address->city;
        $this->street = $address->street;
        $this->number = $address->number;
        $this->complement = $address->complement;
        $this->neighborhood = $address->neighborhood;

        return $this->dispatch('open-address-form-modal');
    }
}
