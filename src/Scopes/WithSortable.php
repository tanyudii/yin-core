<?php

namespace tanyudii\YinCore\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

class WithSortable implements Scope
{
    /**
     * @var Request
     */
    private $request;

    /**
     * WithRelation constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        if ($orderBy = $this->request->get("order_by")) {
            $sorted = in_array(strtolower($this->request->get("sorted_by")), [
                "desc",
                "descending",
            ])
                ? "desc"
                : "asc";
            $builder->orderBy($orderBy, $sorted);
        }
    }
}
