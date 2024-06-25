<?php

namespace App\Repositories\Professional;

use App\Models\Position;
use App\Models\Professional;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfessionalRepository
{
    /**
     * @var Professional
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
        $this->model = new Professional;
        $this->user = $user;
    }

    /**
     * returns a query for the list of objects.
     */
    private function listQuery(array $filterParams, ?int $professionalId = null): Builder
    {
        return $this->model
            ->when($professionalId, function ($q) use ($professionalId) {
                $q->where('id', $professionalId);
            });
    }

    /**
     * Return collection of objects filtered by params.
     */
    public function list(array $filterParams, ?int $professionalId = null): Collection
    {
        $list = $this->listQuery($filterParams, $professionalId)->get();

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
    public function create(array $params): Professional
    {
        return $this->model->create($params);
    }

    /**
     * Update object.
     */
    public function update(array $params, int $professionalId): Professional
    {
        $registry = $this->model->find($professionalId);
        $registry->update($params);

        return $registry;
    }

    /**
     * Delete object.
     */
    public function delete(int $professionalId): bool
    {
        return $this->model->find($professionalId)->delete();
    }

    /**
     * Delete object.
     */
    public function find(int $professionalId): ?Professional
    {
        return $this->model->find($professionalId);
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
     * Returns users to add to professional.
     */
    public function users(?int $professionalId = null): Collection
    {
        return User::whereDoesntHave(
            'professional',
            function ($q) use ($professionalId) {
                $q->when($professionalId,
                    function ($q) use ($professionalId) {
                        $q->whereNot('id', $professionalId);
                    }
                );
            }
        )
            ->get();
    }

    /**
     * Returns the specialties to add to the professional.
     */
    public function specialties(): Collection
    {
        return Specialty::where('status', 'active')->get();
    }

    /**
     * Returns the positions to add to the professional.
     */
    public function positions(): Collection
    {
        return Position::where('status', 'active')->get();
    }
}
