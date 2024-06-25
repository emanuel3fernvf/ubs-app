<?php

namespace App\Services\Professional;

use App\Models\Professional;
use App\Models\User;
use App\Repositories\Professional\ProfessionalRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProfessionalService
{
    /**
     * @var ProfessionalRepository
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
        $this->repository = new ProfessionalRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<Professional>
     */
    public function list(array $requestData, ?int $professionalId = null): Collection
    {
        return $this->repository->list($requestData, $professionalId);
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

            $userName = $this->users()
                ->where('id', $requestData['user_id'])
                ->first()
                ->name;

            $professional = $this->repository->create(
                array_merge($requestData, ['name' => $userName])
            );

            $professional->modelPosition()->updateOrCreate(
                ['model_id' => $professional->id],
                ['position_id' => $requestData['position_id']],
            );

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.professional.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.professional.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $professionalId): array
    {
        DB::beginTransaction();

        try {
            $userName = $this->users($professionalId)
                ->where('id', $requestData['user_id'])
                ->first()
                ->name;

            $professional = $this->list([], $professionalId)->first();

            $this->repository->permission = $this->permission;

            $this->repository->update(
                array_merge($requestData, ['name' => $userName]),
                $professional->id
            );

            $professional->modelPosition()->updateOrCreate(
                ['model_id' => $professional->id],
                ['position_id' => $requestData['position_id']],
            );

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.professional.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.professional.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $professionalId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.professional.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $professional = $this->repository->list([], $professionalId)->first();

            $this->repository->delete($professional->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.professional.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.professional.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $professionalId): array
    {
        try {
            $professional = $this->list([], $professionalId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.professional.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'professional' => $professional,
            ],
        ];
    }

    /**
     * Returns users to add to professional.
     */
    public function users(?int $professionalId = null): Collection
    {
        return $this->repository->users($professionalId);
    }

    /**
     * Returns the specialties to add to the professional.
     */
    public function specialties(): Collection
    {
        return $this->repository->specialties();
    }

    /**
     * Returns the positions to add to the professional.
     */
    public function positions(): Collection
    {
        return $this->repository->positions();
    }
}
