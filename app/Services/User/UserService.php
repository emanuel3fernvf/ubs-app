<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @var UserRepository
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
        $this->repository = new UserRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<User>
     */
    public function list(array $requestData, ?int $userId = null): Collection
    {
        return $this->repository->list($requestData, $userId);
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

            $requestData['password'] = Hash::make($requestData['password']);

            $user = $this->repository->create($requestData);

            $user->modelPosition()->updateOrCreate(
                ['model_id' => $user->id],
                ['position_id' => $requestData['position_id']],
            );

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.user.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.user.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $userId): array
    {
        DB::beginTransaction();

        try {
            $user = $this->list([], $userId)->first();

            $this->repository->permission = $this->permission;
            $requestData['password'] = $requestData['password']
                ? $requestData['password']
                : Hash::make($requestData['password']);

            $this->repository->update(
                $requestData,
                $user->id
            );

            $user->modelPosition()->updateOrCreate(
                ['model_id' => $user->id],
                ['position_id' => $requestData['position_id']],
            );

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.user.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.user.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $userId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.user.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $user = $this->repository->list([], $userId)->first();

            $this->repository->delete($user->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.user.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.user.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $userId): array
    {
        try {
            $user = $this->list([], $userId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.user.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'user' => $user,
            ],
        ];
    }

    /**
     * Returns the positions to add to the user.
     */
    public function positions(): Collection
    {
        return $this->repository->positions();
    }
}
