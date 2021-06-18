<?php

namespace tanyudii\YinCore\Repositories;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use tanyudii\YinCore\Contracts\IServiceRepository;
use tanyudii\YinCore\Contracts\WithDefaultOrderCreatedAt;
use tanyudii\YinCore\Contracts\WithDefaultOrderDesc;
use tanyudii\YinCore\Contracts\WithDeletePolicy;
use tanyudii\YinCore\Contracts\WithPaginate;
use tanyudii\YinCore\Contracts\WithRelationRequest;
use tanyudii\YinCore\Contracts\WithSimplePaginate;
use tanyudii\YinCore\Contracts\WithSortableRequest;
use tanyudii\YinCore\Contracts\WithUpdatePolicy;
use tanyudii\YinCore\Scopes\WithRelation;
use tanyudii\YinCore\Scopes\WithSortable;

abstract class ServiceRepository implements IServiceRepository
{
    use EventServiceRepository, RuleServiceRepository, AuthorizesRequests;

    protected $repository;

    protected $indexResource;

    protected $showResource;

    /**
     * ServiceRepository constructor.
     * @param $repository
     * @param string $indexResource
     * @param string $showResource
     */
    public function __construct(
        $repository,
        string $indexResource = JsonResource::class,
        string $showResource = JsonResource::class
    ) {
        $this->repository = $repository;
        $this->indexResource = $indexResource;
        $this->showResource = $showResource;
    }

    /**
     * @param $payload
     * @return mixed
     */
    public function findAll($payload)
    {
        $queryBuilder = $this->repository->query();

        if ($this->repository instanceof WithRelationRequest) {
            $queryBuilder = $queryBuilder->withGlobalScope(
                ...apply_scope(WithRelation::class)
            );
        }

        if ($this->repository instanceof WithSortableRequest) {
            $queryBuilder = $queryBuilder->withGlobalScope(
                ...apply_scope(WithSortable::class)
            );
        }

        if (method_exists($this->repository, "getTable")) {
            if ($this->repository instanceof WithDefaultOrderCreatedAt) {
                $queryBuilder = $queryBuilder->orderBy(
                    $this->repository->getTable() . ".created_at",
                    $this->repository instanceof WithDefaultOrderDesc
                        ? "DESC"
                        : "ASC"
                );
            }
        }

        $this->applyScopeFindAll($payload, $queryBuilder);

        if ($this->repository instanceof WithSimplePaginate) {
            $data = $queryBuilder->simplePaginate(
                Arr::get($payload, "per_page", 20)
            );
        } elseif ($this->repository instanceof WithPaginate) {
            $data = $queryBuilder->paginate(Arr::get($payload, "per_page", 20));
        } else {
            $data = $queryBuilder->get();
        }

        return $data;
    }

    /**
     * @param $payload
     * @return mixed|null
     */
    public function findOne($payload)
    {
        if (!isset($payload["id"])) {
            return null;
        }

        $queryBuilder = $this->repository->query();

        if ($this->repository instanceof WithRelationRequest) {
            $queryBuilder = $queryBuilder->withGlobalScope(
                ...apply_scope(WithRelation::class)
            );
        }

        $this->applyScopeFindOne($payload, $queryBuilder);

        return $queryBuilder->find($payload["id"]);
    }

    /**
     * @param $payload
     * @return mixed|null
     * @throws ValidationException
     */
    public function create($payload)
    {
        $validator = Validator::make($payload, $this->createRules($payload));

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->beforeCreate($payload);

        $data = new $this->repository();

        $data->fill($payload);

        $this->onCreate($data, $payload);

        $data->save();

        $this->afterCreate($data, $payload);

        return $data;
    }

    /**
     * @param $payload
     * @return Builder|Builder[]|Collection|Model|mixed|null
     * @throws ValidationException|AuthorizationException
     */
    public function update($payload)
    {
        $validator = Validator::make($payload, $this->updateRules($payload));

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->beforeUpdate($payload);

        $queryBuilder = $this->repository->query();

        $this->applyScopeUpdate($payload, $queryBuilder);

        $data = $queryBuilder->findOrFail($payload["id"]);

        if ($data instanceof WithUpdatePolicy) {
            $this->authorize(__FUNCTION__, $data);
        }

        $data->fill($payload);

        $this->onUpdate($data, $payload);

        $data->save();

        $this->afterUpdate($data, $payload);

        return $data;
    }

    /**
     * @param $payload
     * @return int
     * @throws ValidationException|AuthorizationException
     */
    public function delete($payload)
    {
        $validator = Validator::make($payload, $this->deleteRules($payload));

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->beforeDelete($payload);

        $ids = isset($payload["id"]) ? [$payload["id"]] : [];
        if (isset($payload["ids"]) && is_array($payload)) {
            array_push($ids, $payload["ids"]);
        }

        $queryBuilder = $this->repository->query();

        $this->applyScopeDelete($payload, $queryBuilder);

        $items = $queryBuilder->whereIn("id", $ids)->get();

        if (!$items->isEmpty()) {
            if ($items[0] instanceof WithDeletePolicy) {
                foreach ($items as $item) {
                    $this->authorize(__FUNCTION__, $item);

                    $item->delete();

                    $this->onDelete($item, $payload);
                }
            } else {
                foreach ($items as $item) {
                    $item->delete();

                    $this->onDelete($item, $payload);
                }
            }
        }

        $this->afterDelete($items, $payload);

        return $items->count();
    }
}
