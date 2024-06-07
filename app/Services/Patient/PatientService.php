<?php

namespace App\Services\Patient;

use App\Models\User;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PatientService
{
    /**
     * @var PatientRepository
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
        $this->repository = new PatientRepository($user);
    }

    /**
     * Return collection of objects filtered by request params.
     *
     * @return Collection<Patient>
     */
    public function list(array $requestData, ?int $patientId = null): Collection
    {
        return $this->repository->list($requestData, $patientId);
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
            $this->repository->create($requestData);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.patient.error.create').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.patient.success.create'),
        ];
    }

    /**
     * Update object.
     */
    public function update(array $requestData, int $patientId): array
    {
        DB::beginTransaction();

        try {
            $patient = $this->list([], $patientId)->first();

            $this->repository->permission = $this->permission;
            $this->repository->update($requestData, $patient->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.patient.error.update').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.patient.success.update'),
        ];
    }

    /**
     * Delete object.
     *
     * @param  bool|null  $confirmation
     */
    public function delete(int $patientId, bool $confirmation = false): array
    {
        if (! $confirmation) {
            return [
                'success' => false,
                'type' => 'confirmation',
                'message' => __('messages.patient.confirmation.delete'),
            ];
        }

        DB::beginTransaction();

        try {

            $this->repository->permission = $this->permission;
            $patient = $this->repository->list([], $patientId)->first();

            $this->repository->delete($patient->id);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $mensagem = __('messages.patient.error.delete').": \n";

            return [
                'success' => false,
                'type' => 'error',
                'message' => $mensagem.$e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'type' => 'success',
            'message' => __('messages.patient.success.delete'),
        ];
    }

    /**
     * Return object to edit.
     */
    public function show(int $patientId): array
    {
        try {
            $patient = $this->list([], $patientId)->first();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('messages.patient.error.find'),
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => '',
            'data' => [
                'patient' => $patient,
            ],
        ];
    }
}
