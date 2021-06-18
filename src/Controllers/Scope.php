<?php

namespace tanyudii\YinCore\Controllers;

use Illuminate\Http\Request;

trait Scope
{
    /**
     * @param Request $request
     * @param $builder
     * @return void
     */
    public function applyScopeIndex(Request $request, &$builder)
    {
        //
    }

    /**
     * @param Request $request
     * @param $builder
     * @return void
     */
    public function applyScopeShow(Request $request, &$builder)
    {
        //
    }

    /**
     * @param Request $request
     * @param $builder
     * @return void
     */
    public function applyScopeDestroy(Request $request, &$builder)
    {
        //
    }
}
