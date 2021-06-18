<?php

namespace tanyudii\YinCore\Repositories;

use tanyudii\YinCore\Rules\NotPresent;

trait RuleServiceRepository
{
    /**
     * @param $payload
     * @return array
     */
    public function createRules($payload)
    {
        return [];
    }

    /**
     * @param $payload
     * @return array
     */
    public function updateRules($payload)
    {
        return [];
    }

    /**
     * @param $payload
     * @return array
     */
    public function deleteRules($payload)
    {
        return [
            "id" => ["required_without:ids"],
            "ids" => ["required_without:id", "array"],
        ];
    }

    /**
     * @return array
     */
    public function defaultRules()
    {
        $defaultRules = [];

        if (method_exists($this->repository, "getFillable")) {
            $fields = $this->repository->getFillable();
            foreach ($fields as $field) {
                $defaultRules[$field] = [new NotPresent()];
            }
        }

        return $defaultRules;
    }
}
