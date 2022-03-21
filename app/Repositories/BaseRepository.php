<?php


namespace App\Repositories;

use App\Contracts\EloquentRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BaseRepository implements EloquentRepositoryContract
{

    protected Model $model;

    private bool $uploadingImage = false;

    /**
     * BaseRepository constructor.
     * @param Model $m
     */
    public function __construct(Model $m)
    {
        $this->model = $m;
    }

    /**
     * Get all records.
     *
     * @param array $relations
     * @param array $conditions
     * @return Collection
     */
    public function all(array $relations = [], array $conditions = []): Collection
    {
        if (count($conditions) > 0) {
            return $this->model->with($relations)->where($conditions)->get();
        }
        return $this->model->with($relations)->get();
    }

    /**
     * @param int $length
     * @param array $conditions
     * @return mixed
     */
    public function pagination(int $length = 10, array $conditions = []): mixed
    {
        if ( empty($conditions) ) {
            return $this->model->paginate($length);
        }
        return $this->model
            ->where($conditions)
            ->paginate($length);
    }

    /**
     * @param int $length
     * @param string $pageName
     * @param int $pageNumber
     * @param array $conditions
     * @param array $hasRelationship
     * @param array $hasCallBack
     * @return LengthAwarePaginator
     */
    public function withPagination(int $length = 12, string $pageName = "page", int $pageNumber = 1, array $conditions = [], array $hasRelationship = [], array $hasCallBack = []): LengthAwarePaginator
    {
        $length = $length > 0 ? $length : 12;
        if (empty($conditions) && empty($hasRelationship) && empty($hasCallBack) || (count($hasRelationship) != count($hasCallBack))) {
            return $this->model->paginate(
                perPage: $length, pageName: $pageName, page: $pageNumber
            );
        }

        $result = $this->model->query();
        foreach ($hasRelationship as $key => $relationship) {
            $result = $result
                ->whereHas($relationship, $hasCallBack[$key]);
        }
        return $result->where($conditions)->paginate(
            perPage: $length, pageName: $pageName, page: $pageNumber
        );
    }

    /**
     * Get all trashed records.
     * @param array $relations
     * @return Collection
     */
    public function allTrashed(array $relations = []): Collection
    {
        return $this->model->withTrashed()->with($relations)->get();
    }

    /**
     * @param array $relations
     * @param array $conditions
     * @return Collection
     */
    public function onlyTrashed(array $relations = [], array $conditions = []): Collection
    {
        if (!empty($conditions)) {
            return $this->model->onlyTrashed()
                ->where($conditions)
                ->with($relations)->get();
        }
        return $this->model->onlyTrashed()->with($relations)->get();
    }

    /**
     * @param string $identifier
     * @param array $relations
     * @return ?Model
     */
    public function findByIdentifier(string $identifier, array $relations = []): ?Model
    {
        return $this->model->where("identifier", $identifier)->with($relations)->first();
    }

    /**
     * Find trashed record by identifier.
     *
     * @param string $identifier
     * @return ?Model
     */
    public function findTrashedByIdentifier(string $identifier): ?Model
    {
        return $this->model->withTrashed()->where("identifier", $identifier)->first();
    }

    /**
     * Find trashed record by id.
     *
     * @param int $id
     * @param array $relations
     * @return ?Model
     */
    public function findTrashedById(int $id, array $relations): ?Model
    {
        return $this->model->withTrashed()->where("id", $id)->with($relations)->first();
    }

    /**
     * Create new model record.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function checkDirty(int $id, array $data): bool
    {
        $model = $this->model->find($id);
        return $model->fill($data)->isDirty();
    }

    /**
     * Find record by id.
     *
     * @param int $id
     * @param array $relations
     * @param array $withCount
     * @return ?Model
     */
    public function findById(int $id, array $relations = [], array $withCount = []): ?Model
    {
        if (empty($withCount)) {
            return $this->model->where("id", $id)->with($relations)->first();
        }
        return $this->model->where("id", $id)->with($relations)->withCount($withCount)->first();
    }

    /**
     * Delete record by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Delete record by identifier.
     *
     * @param string $identifier
     * @return bool
     */
    public function deleteByIdentifier(string $identifier): bool
    {
        return $this->model->where('identifier', $identifier)->delete();
    }

    /**
     * @param int $staffId
     * @return bool
     */
    public function forceDelete(int $staffId): bool
    {
        return $this->update($staffId, [
            "permanently_deleted" => 1,
            "permanently_deleted_at" => date("Y-m-d H:i:s")
        ]);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $model = $this->model->withTrashed()->where("id", $id)->first();
        $model->fill($data);

        if ($model->isClean() && !$this->isUploadingImage()) {
            return false;
        }
        return $model->update();
    }

    /**
     * @return bool
     */
    public function isUploadingImage(): bool
    {
        return $this->uploadingImage;
    }

    /**
     * @param bool $uploadingImage
     * @return $this
     */
    public function setUploadingImage(bool $uploadingImage): BaseRepository
    {
        $this->uploadingImage = $uploadingImage;
        return $this;
    }

    /**
     * Restore record by id.
     *
     * @param int $id
     * @return bool
     */
    public function restoreById(int $id): bool
    {
        return $this->model->onlyTrashed()->where('id', $id)->restore();
    }

    /**
     * Restore record by id.
     *
     * @param string $identifier
     * @return bool
     */
    public function restoreByIdentifier(string $identifier): bool
    {
        return $this->model->where('identifier', $identifier)->restore();
    }

    /**
     * @return Collection
     */
    public function restorable(): Collection
    {
        return $this->model
            ->onlyTrashed()
            ->whereDate("created_at", ">", date("Y-m-d", strtotime("-1 month")))
            ->whereDate("created_at", "<=", date("Y-m-d"))
            ->where("permanently_deleted", 0)
            ->whereNull("permanently_deleted_at")
            ->get();
    }

    /**
     * To begin database transaction so no changes will be saved unless they were committed.
     * @return void
     */
    protected function beginDatabaseTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * To commit all the changes that was made to the database
     * @return void
     */
    protected function commitDatabaseChanges()
    {
        DB::commit();
    }

    /**
     * To roll back all the changes that make to the database.
     * @return void
     */
    protected function rollBackDatabaseChanges()
    {
        DB::rollBack();
    }
}
