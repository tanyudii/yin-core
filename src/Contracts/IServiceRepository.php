<?php

namespace tanyudii\YinCore\Contracts;

interface IServiceRepository
{
    /**
     * @param $payload
     * @return mixed
     */
    public function findAll($payload);

    /**
     * @param $payload
     * @return mixed
     */
    public function findOne($payload);

    /**
     * @param $payload
     * @return mixed
     */
    public function create($payload);

    /**
     * @param $payload
     * @return mixed
     */
    public function update($payload);

    /**
     * @param $payload
     * @return mixed
     */
    public function delete($payload);

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeFindAll($payload, &$builder);

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeFindOne($payload, &$builder);

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeUpdate($payload, &$builder);

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeDelete($payload, &$builder);

    /**
     * @param $payload
     */
    public function beforeCreate(&$payload);

    /**
     * @param $model
     * @param $payload
     */
    public function onCreate($model, &$payload);

    /**
     * @param $model
     * @param $payload
     */
    public function afterCreate($model, &$payload);

    /**
     * @param $payload
     */
    public function beforeUpdate(&$payload);

    /**
     * @param null $model
     * @param $payload
     */
    public function onUpdate($model, &$payload);

    /**
     * @param $model
     * @param $payload
     */
    public function afterUpdate($model, &$payload);

    /**
     * @param $payload
     */
    public function beforeDelete(&$payload);

    /**
     * @param $model
     * @param $payload
     */
    public function onDelete($model, &$payload);

    /**
     * @param $model
     * @param $payload
     */
    public function afterDelete($model, &$payload);

    /**
     * @param $payload
     * @return array
     */
    public function createRules($payload);

    /**
     * @param $payload
     * @return array
     */
    public function updateRules($payload);

    /**
     * @param $payload
     * @return array
     */
    public function deleteRules($payload);
}
