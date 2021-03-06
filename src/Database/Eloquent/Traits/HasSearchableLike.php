<?php

namespace tanyudii\YinCore\Database\Eloquent\Traits;

trait HasSearchableLike
{
    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLike($query, $search, array $columns = []): void
    {
        $query->where(function ($query) use ($search, $columns) {
            if (!empty($search)) {
                foreach ($columns as $index => $column) {
                    if ($index == 0) {
                        $query->where($column, "like", "%$search%");
                    } else {
                        $query->orWhere($column, "like", "%$search%");
                    }
                }
            }
        });
    }

    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLikeRight($query, $search, array $columns = []): void
    {
        $query->where(function ($query) use ($search, $columns) {
            if (!empty($search)) {
                foreach ($columns as $index => $column) {
                    if ($index == 0) {
                        $query->where($column, "like", "$search%");
                    } else {
                        $query->orWhere($column, "like", "$search%");
                    }
                }
            }
        });
    }

    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLikeLeft($query, $search, array $columns = []): void
    {
        $query->where(function ($query) use ($search, $columns) {
            if (!empty($search)) {
                foreach ($columns as $index => $column) {
                    if ($index == 0) {
                        $query->where($column, "like", "%$search");
                    } else {
                        $query->orWhere($column, "like", "%$search");
                    }
                }
            }
        });
    }

    /**
     * @return array
     */
    public function getDefaultSearchableLike(): array
    {
        return [];
    }
}
