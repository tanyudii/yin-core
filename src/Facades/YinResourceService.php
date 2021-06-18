<?php

namespace tanyudii\YinCore\Facades;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Facade;

/**
 * @method static AnonymousResourceCollection jsonCollection($resource, $data, $additional = [])
 * @method static JsonResource jsonResource($resource, $data, $additional = [])
 *
 * @see \tanyudii\YinCore\Services\YinResourceService
 */
class YinResourceService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "yin-resource-service";
    }
}
