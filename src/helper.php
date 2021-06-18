<?php

if (!function_exists('arr_strict')) {
    /**
     * The helper for strict value must be array
     *
     * @param $value
     * @return array
     */
    function arr_strict($value): array
    {
        return is_array($value) ? $value : [$value];
    }
}

if (!function_exists('apply_scope')) {
    function apply_scope(string $scope): array
    {
        return [
            $scope,
            app($scope)
        ];
    }
}
