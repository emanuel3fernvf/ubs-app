<?php

namespace App\Repositories\Patient;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientRepository
{
    /**
     * @var Patient
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
        $this->model = new Patient;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $patientId = null): Builder
    {
        return $this->model
            ->when($patientId, function ($q) use ($patientId) {
                $q->where('id', $patientId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $patientId = null): Collection
    {
        $list = $this->listQuery($filterParams, $patientId)->get();

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
    public function create(array $params): Patient
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $patientId): Patient
    {
        $registry = $this->model->find($patientId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $patientId): bool
    {
        return $this->model->find($patientId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $patientId): ?Patient
    {
        return $this->model->find($patientId);
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
