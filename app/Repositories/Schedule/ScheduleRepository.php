<?php

namespace App\Repositories\Schedule;

use App\Models\Patient;
use App\Models\Professional;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ScheduleRepository
{
    /**
     * @var Schedule
     */
    private $model;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    public $permission;

    /**
     * * Repository constructor.
     */
    public function __construct(User $user)
    {
        $this->model = new Schedule;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $scheduleId = null): Builder
    {
        return $this->model
            ->when($scheduleId, function ($q) use ($scheduleId) {
                $q->where('id', $scheduleId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $scheduleId = null): Collection
    {
        $list = $this->listQuery($filterParams, $scheduleId)->get();

        return $this->collectionAppends($list);
    }

    /**
     * Return paginated collection of objects filtered by params.
     */
    public function listWithPagination(array $filterParams, ?int $perPage = null): LengthAwarePaginator
    {
        /**
         * @var LengthAwarePaginator
         */
        $paginator = $this->listQuery($filterParams)->paginate($perPage);

        $collectionAppends = $this->collectionAppends(
            $paginator->getCollection()
        );

        return $paginator->setCollection($collectionAppends);
    }

    /**
     * Create new object.
     */
    public function create(array $params): Schedule
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $scheduleId): Schedule
    {
        $registry = $this->model->find($scheduleId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $scheduleId): bool
    {
        return $this->model->find($scheduleId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $scheduleId): ?Schedule
    {
        return $this->model->find($scheduleId);
    }

    /**
     * Return a collection with appends.
     */
    private function collectionAppends(Collection $collection): Collection
    {
        $callback = function ($item) {
            return $item;
        };

        return $collection->map($callback);
    }

    public function formData(): array
    {
        $professionals = $this->professionals()->get();
        $patients = $this->patients()->get();

        return compact('professionals', 'patients');
    }

    private function professionals(): Builder
    {
        return Professional::where('status', 'active');
    }

    private function patients(): Builder
    {
        return Patient::where('status', 'active');
    }
}
