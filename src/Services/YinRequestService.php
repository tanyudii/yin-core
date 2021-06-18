<?php

namespace tanyudii\YinCore\Services;

use tanyudii\YinCore\Rules\NotPresent;

class YinRequestService
{
    /**
     * @param string $model
     * @return array
     */
    public function getDefaultRules(string $model)
    {
        $model = app($model);

        $fields = $model->getFillable();

        $rules = [];
        foreach ($fields as $field) {
            $rules[$field] = [new NotPresent()];
        }

        return $rules;
    }
}
