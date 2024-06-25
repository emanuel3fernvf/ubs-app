<?php

namespace App\Repositories\User;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * @var User
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
        $this->model = new User;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $userId = null): Builder
    {
        return $this->model
            ->when($userId, function ($q) use ($userId) {
                $q->where('id', $userId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $userId = null): Collection
    {
        $list = $this->listQuery($filterParams, $userId)->get();

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
    public function create(array $params): User
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $userId): User
    {
        $registry = $this->model->find($userId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $userId): bool
    {
        return $this->model->find($userId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $userId): ?User
    {
        return $this->model->find($userId);
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

    /**
     * Returns the positions to add to the user.
     */
    public function positions(): Collection
    {
        return Position::where('status', 'active')->get();
    }
}
