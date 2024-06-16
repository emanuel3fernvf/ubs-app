<?php

namespace App\Services\Unit;

use App\Models\User;
use App\Repositories\Unit\UnitRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UnitService
{
    /**
     * @var UnitRepository
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
        $this->repository = new UnitRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<Unit>
     */
    public function list(array $requestData, ?int $unitId = null): Collection
    {
        return $this->repository->list($requestData, $unitId);
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

            $mensagem = __('messages.unit.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.unit.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $unitId): array
    {
        DB::beginTransaction();

        try {
            $unit = $this->list([], $unitId)->first();

            $this->repository->permission = $this->permission;
            $this->repository->update($requestData, $unit->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.unit.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.unit.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $unitId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.unit.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $unit = $this->repository->list([], $unitId)->first();

            $this->repository->delete($unit->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.unit.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.unit.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $unitId): array
    {
        try {
            $unit = $this->list([], $unitId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.unit.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'unit' => $unit,
            ],
        ];
    }
}
