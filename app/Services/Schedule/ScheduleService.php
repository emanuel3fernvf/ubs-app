<?php

namespace App\Services\Schedule;

use App\Models\User;
use App\Repositories\Schedule\ScheduleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    /**
     * @var ScheduleRepository
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
        $this->repository = new ScheduleRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<Schedule>
     */
    public function list(array $requestData, ?int $scheduleId = null): Collection
    {
        $this->repository->permission = $this->permission;
        return $this->repository->list($requestData, $scheduleId);
    }

    /**
     * Return paginated collection of objects filtered by params.
     */
    public function listWithPagination(array $requestData, ?int $perPage = null): LengthAwarePaginator
    {
        $this->repository->permission = $this->permission;
        return $this->repository->listWithPagination($requestData, $perPage);
    }

    /**
     * Create new object.
     */
    public function create(array $requestData): array
    {
        DB::beginTransaction();

        try {

            $requestData['date'] = $requestData['date'].' '.$requestData['time'];

            $this->repository->permission = $this->permission;
            $this->repository->create($requestData);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.schedule.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.schedule.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $scheduleId): array
    {
        DB::beginTransaction();

        try {

            $requestData['date'] = $requestData['date'].' '.$requestData['time'];
            $schedule = $this->list([], $scheduleId)->first();

            $this->repository->permission = $this->permission;
            $this->repository->update($requestData, $schedule->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.schedule.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.schedule.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $scheduleId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.schedule.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $schedule = $this->repository->list([], $scheduleId)->first();

            $this->repository->delete($schedule->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.schedule.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.schedule.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $scheduleId): array
    {
        try {
            $schedule = $this->list([], $scheduleId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.schedule.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'schedule' => $schedule,
            ],
        ];
    }

    /**
     * Returns data to create a schedule
     *
     * @return array
     */
    public function formData(): array
    {
        try {
            $this->repository->permission = $this->permission;
            $data = $this->repository->formData();
        } catch (\Exception $e) {
            $mensagem = __('messages.schedule.error.create').": \n";

            return [
                'success' => false,
                'message' => $mensagem.$e->getMessage(),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => $data,
        ];
    }
}
