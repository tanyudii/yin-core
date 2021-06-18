<?php

namespace tanyudii\YinCore\Repositories;

trait EventServiceRepository
{
    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeFindAll($payload, &$builder)
    {
        //
    }

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeFindOne($payload, &$builder)
    {
        //
    }

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeUpdate($payload, &$builder)
    {
        //
    }

    /**
     * @param $payload
     * @param $builder
     */
    public function applyScopeDelete($payload, &$builder)
    {
        //
    }

    /**
     * @param $payload
     */
    public function beforeCreate(&$payload)
    {
        //
    }

    /**
     * @param $model
     * @param $payload
     */
    public function onCreate($model, &$payload)
    {
        //
    }

    /**
     * @param $model
     * @param $payload
     */
    public function afterCreate($model, &$payload)
    {
        //
    }

    /**
     * @param $payload
     */
    public function beforeUpdate(&$payload)
    {
        //
    }

    /**
     * @param $model
     * @param $payload
     */
    public function onUpdate($model, &$payload)
    {
        //
    }

    /**
     * @param $model
     * @param $payload
     */
    public function afterUpdate($model, &$payload)
    {
        //
    }

    /**
     * @param $payload
     */
    public function beforeDelete(&$payload)
    {
        //
    }

    /**
     * @param $model
     * @param $payload
     */
    public function onDelete($model, &$payload)
    {
        //
    }

    /**
     * @param $model
     * @param $payload
     */
    public function afterDelete($model, &$payload)
    {
        //
    }
}
