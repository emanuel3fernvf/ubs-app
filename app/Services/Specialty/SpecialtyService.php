<?php

namespace App\Services\Specialty;

use App\Models\User;
use App\Repositories\Specialty\SpecialtyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SpecialtyService
{
    /**
     * @var SpecialtyRepository
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
        $this->repository = new SpecialtyRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<Specialty>
     */
    public function list(array $requestData, ?int $specialtyId = null): Collection
    {
        return $this->repository->list($requestData, $specialtyId);
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

            $this->repository->permission = $this->permission;
            $this->repository->create($requestData);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.specialty.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.specialty.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $specialtyId): array
    {
        DB::beginTransaction();

        try {
            $specialty = $this->list([], $specialtyId)->first();

            $this->repository->permission = $this->permission;
            $this->repository->update($requestData, $specialty->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.specialty.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.specialty.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $specialtyId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.specialty.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $specialty = $this->repository->list([], $specialtyId)->first();

            $this->repository->delete($specialty->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.specialty.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.specialty.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $specialtyId): array
    {
        try {
            $specialty = $this->list([], $specialtyId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.specialty.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'specialty' => $specialty,
            ],
        ];
    }
}
