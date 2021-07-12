<?php

namespace tanyudii\YinCore\Contracts;

interface WithSearchableLike
{
    /**
     * @param $query
     * @param $search
     * @param $columns
     */
    public function scopeSearchLike($query, $search, $columns): void;

    /**
     * @return array
     */
    public function getDefaultSearchableLike(): array;
}
