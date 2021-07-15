<?php

namespace tanyudii\YinCore\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use tanyudii\YinCore\Contracts\WithDefaultOrderCreatedAt;
use tanyudii\YinCore\Contracts\WithDefaultOrderDesc;
use tanyudii\YinCore\Contracts\WithPaginate;
use tanyudii\YinCore\Contracts\WithRelationRequest;
use tanyudii\YinCore\Contracts\WithSimplePaginate;
use tanyudii\YinCore\Contracts\WithSortableRequest;
use tanyudii\YinCore\Facades\YinResourceService;
use tanyudii\YinCore\Scopes\WithRelation;
use tanyudii\YinCore\Scopes\WithSortable;

trait YinRestController
{
    use Observer, Scope;

    /**
     * @var Model
     */
    protected $repository;

    /**
     * @var string[]
     */
    protected $fillAble;

    /**
     * @var string
     */
    protected $indexResource;

    /**
     * @var string
     */
    protected $showResource;

    /**
     * YinRestController constructor.
     * @param Model $repository
     * @param string $indexResource
     * @param string $showResource
     */
    public function __construct(
        Model $repository,
        string $indexResource = JsonResource::class,
        string $showResource = JsonResource::class
    ) {
        $this->repository = $repository;
        $this->fillAble = $repository->getFillable();

        $this->indexResource = $indexResource;
        $this->showResource = $showResource;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $qb = $this->repository->query();

        if ($this->repository instanceof WithRelationRequest) {
            $qb = $qb->withGlobalScope(...apply_scope(WithRelation::class));
        }

        if ($this->repository instanceof WithSortableRequest) {
            $qb = $qb->withGlobalScope(...apply_scope(WithSortable::class));
        }

        if ($this->repository instanceof WithDefaultOrderCreatedAt && !$this->repository instanceof WithSortableRequest || !$request->has('order_by')) {
            $qb = $qb->orderBy(
                $this->repository->getTable() . ".created_at",
                $this->repository instanceof WithDefaultOrderDesc
                    ? "DESC"
                    : "ASC"
            );
        }

        $this->applyScopeIndex($request, $qb);

        if ($this->repository instanceof WithSimplePaginate) {
            $data = $qb->simplePaginate($request->get("per_page", 20));
        } elseif ($this->repository instanceof WithPaginate) {
            $data = $qb->paginate($request->get("per_page", 20));
        } else {
            $data = $qb->get();
        }

        return YinResourceService::jsonCollection($this->indexResource, $data);
    }

    /**
     * @param Request $request
     * @return JsonResource
     */
    public function show(Request $request)
    {
        $qb = $this->repository->query();

        if ($this->repository instanceof WithRelationRequest) {
            $qb = $qb->withGlobalScope(...apply_scope(WithRelation::class));
        }

        $this->applyScopeShow($request, $qb);

        $data = $qb->findOrFail($request->route("id"));

        return YinResourceService::jsonResource($this->showResource, $data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request)
    {
        $qb = $this->repository->query();

        $this->applyScopeDestroy($request, $qb);

        $data = $qb->where("id", $request->route("id"))->firstOrFail();

        $this->beforeDestroy($request, $data);

        $data->delete();

        $this->afterDestroy($request, $data);

        return Response::json([
            "success" => true,
            "message" => "Successfully delete data.",
            "data" => $data,
        ]);
    }
}
