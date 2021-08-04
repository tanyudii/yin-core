<?php

namespace tanyudii\YinCore\Contracts;

interface WithSearchableLike
{
    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLike($query, $search, array $columns = []): void;

    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLikeRight($query, $search, array $columns = []): void;

    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLikeLeft($query, $search, array $columns = []): void;

    /**
     * @return array
     */
    public function getDefaultSearchableLike(): array;
}
