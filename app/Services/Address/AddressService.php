<?php

namespace App\Services\Address;

use App\Models\User;
use App\Repositories\Address\AddressRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AddressService
{
    /**
     * @var AddressRepository
     */
    private $repository;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    public $permission;

    /**
     * Service constructor.
     *
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->repository = new AddressRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<Address>
     */
    public function list(array $requestData, ?int $addressId = null): Collection
    {
        return $this->repository->list($requestData, $addressId);
    }

    /**
     * Return paginated collection of objects filtered by params.
     */
    public function listWithPagination(array $requestData, ?int $perPage = null): LengthAwarePaginator
    {
        return $this->repository->listWithPagination($requestData, $perPage);
    }

    /**
     * Create new object.
     */
    public function create(array $requestData): array
    {
        DB::beginTransaction();

        try {
            if (! $requestData['number']) {
                unset($requestData['number']);
            }

            $this->repository->permission = $this->permission;
            $this->repository->create($requestData);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.address.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.address.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $addressId): array
    {
        DB::beginTransaction();

        try {
            if (! $requestData['number']) {
                unset($requestData['number']);
            }

            $address = $this->list([], $addressId)->first();

            $this->repository->permission = $this->permission;
            $this->repository->update($requestData, $address->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.address.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.address.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $addressId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.address.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $address = $this->repository->list([], $addressId)->first();

            $this->repository->delete($address->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.address.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.address.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $addressId): array
    {
        try {
            $address = $this->list([], $addressId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.address.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'address' => $address,
            ],
        ];
    }
}
