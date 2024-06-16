<?php

namespace App\Repositories\Unit;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitRepository
{
    /**
     * @var Unit
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
        $this->model = new Unit;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $unitId = null): Builder
    {
        return $this->model
            ->when($unitId, function ($q) use ($unitId) {
                $q->where('id', $unitId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $unitId = null): Collection
    {
        $list = $this->listQuery($filterParams, $unitId)->get();

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
    public function create(array $params): Unit
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $unitId): Unit
    {
        $registry = $this->model->find($unitId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $unitId): bool
    {
        return $this->model->find($unitId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $unitId): ?Unit
    {
        return $this->model->find($unitId);
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
}
