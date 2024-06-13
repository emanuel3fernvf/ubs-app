<?php

namespace App\Repositories\Address;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AddressRepository
{
    /**
     * @var Address
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
        $this->model = new Address;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $addressId = null): Builder
    {
        return $this->model
            ->when($addressId, function ($q) use ($addressId) {
                $q->where('id', $addressId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $addressId = null): Collection
    {
        $list = $this->listQuery($filterParams, $addressId)->get();

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
    public function create(array $params): Address
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $addressId): Address
    {
        $registry = $this->model->find($addressId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $addressId): bool
    {
        return $this->model->find($addressId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $addressId): ?Address
    {
        return $this->model->find($addressId);
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
