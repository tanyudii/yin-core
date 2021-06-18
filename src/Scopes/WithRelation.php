<?php

namespace tanyudii\YinCore\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

class WithRelation implements Scope
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
        $builder->with(arr_strict($this->request->get("with", [])));
    }
}
