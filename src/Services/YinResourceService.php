<?php

namespace tanyudii\YinCore\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class YinResourceService
{
    /**
     * @param $resource
     * @param $data
     * @param array $additional
     *
     * @return AnonymousResourceCollection
     */
    public function jsonCollection($resource, $data, array $additional = [])
    {
        if ($resource && is_subclass_of($resource, JsonResource::class)) {
            return $resource::collection($data)->additional($additional);
        }

        return JsonResource::collection($data)->additional($additional);
    }

    /**
     * @param $resource
     * @param $data
     * @param array $additional
     *
     * @return JsonResource
     */
    public function jsonResource($resource, $data, array $additional = [])
    {
        if ($resource && is_subclass_of($resource, JsonResource::class)) {
            return (new $resource($data))->additional($additional);
        }

        return (new JsonResource($data))->additional($additional);
    }
}
