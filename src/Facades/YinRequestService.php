<?php

namespace tanyudii\YinCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getDefaultRules(string $model)
 *
 * @see \tanyudii\YinCore\Services\YinRequestService
 */
class YinRequestService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "yin-request-service";
    }
}
