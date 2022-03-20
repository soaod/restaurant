<?php


namespace App\Contracts;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryContract
{
    /**
     * Get all records.
     *
     * @param array $relations
     * @param array $conditions
     * @return Collection
     */
    public function all(array $relations = [], array $conditions = []): Collection;

    /**
     * Get all trashed records.
     * @param array $relations
     * @return Collection
     */
    public function allTrashed(array $relations = []): Collection;

    /**
     * Find record by id.
     *
     * @param int $id
     * @param array $relations
     * @return ?Model
     */
    public function findById(int $id, array $relations = []): ?Model;

    /**
     * @param string $identifier
     * @param array $relations
     * @return ?Model
     */
    public function findByIdentifier(string $identifier, array $relations = []): ?Model;

    /**
     * Find trashed record by id.
     *
     * @param int $id
     * @param array $relations
     * @return ?Model
     */
    public function findTrashedById(int $id, array $relations): ?Model;

    /**
     * Find trashed record by identifier.
     *
     * @param string $identifier
     * @return ?Model
     */
    public function findTrashedByIdentifier(string $identifier): ?Model;

    /**
     * Create new model record.
     * @param array $data
     * @return ?Model
     */
    public function create(array $data): ?Model;

    /**
     * Update existing record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete record by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * Delete record by identifier.
     *
     * @param string $identifier
     * @return bool
     */
    public function deleteByIdentifier(string $identifier): bool;

    /**
     * Restore record by id.
     *
     * @param int $id
     * @return bool
     */
    public function restoreById(int $id): bool;

    /**
     * Restore record by id.
     *
     * @param string $identifier
     * @return bool
     */
    public function restoreByIdentifier(string $identifier): bool;
}
