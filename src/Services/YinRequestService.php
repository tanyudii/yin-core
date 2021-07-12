<?php

namespace tanyudii\YinCore\Services;

use tanyudii\YinCore\Exceptions\YinCoreException;
use tanyudii\YinCore\Rules\NotPresent;

class YinRequestService
{
    /**
     * @param string $model
     * @return array
     * @throws YinCoreException
     */
    public function getDefaultRules(string $model)
    {
        $model = new $model();

        if (!method_exists($model, 'getFillable')) {
            throw new YinCoreException("The model is invalid.");
        }

        $fields = $model->getFillable();

        $rules = [];
        foreach ($fields as $field) {
            $rules[$field] = [new NotPresent()];
        }

        return $rules;
    }
}
