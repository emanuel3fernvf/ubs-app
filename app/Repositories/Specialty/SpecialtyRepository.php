<?php

namespace App\Repositories\Specialty;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SpecialtyRepository
{
    /**
     * @var Specialty
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
        $this->model = new Specialty;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $specialtyId = null): Builder
    {
        return $this->model
            ->when($specialtyId, function ($q) use ($specialtyId) {
                $q->where('id', $specialtyId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $specialtyId = null): Collection
    {
        $list = $this->listQuery($filterParams, $specialtyId)->get();

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
    public function create(array $params): Specialty
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $specialtyId): Specialty
    {
        $registry = $this->model->find($specialtyId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $specialtyId): bool
    {
        return $this->model->find($specialtyId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $specialtyId): ?Specialty
    {
        return $this->model->find($specialtyId);
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
