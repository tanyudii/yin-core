<?php

namespace tanyudii\YinCore\Database\Eloquent\Traits;

trait WithSearchableLike
{
    /**
     * @param $query
     * @param $search
     * @param array $columns
     */
    public function scopeSearchLike($query, $search, $columns = [])
    {
        if (!empty($search)) {
            foreach ($columns as $index => $column) {
                if ($index == 0) {
                    $query->where($column, "like", "%$search%");
                } else {
                    $query->orWhere($column, "like", "%$search%");
                }
            }
        }
    }
}
