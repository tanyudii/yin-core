<?php

namespace tanyudii\YinCore\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait Observer
{
    /**
     * @param Request $request
     * @param Model $model
     * del $model
     */
    public function beforeDestroy(Request $request, Model $model)
    {
        //
    }

    /**
     * @param Request $request
     * @param Model $model
     */
    public function afterDestroy(Request $request, Model $model)
    {
        //
    }
}
