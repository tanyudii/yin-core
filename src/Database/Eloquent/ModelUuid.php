<?php

namespace tanyudii\YinCore\Database\Eloquent;

use Exception;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Ramsey\Uuid\Uuid as RamseyUuid;

abstract class ModelUuid extends BaseModel
{
    /**
     * Disable incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Change key data type
     *
     * @var string
     */
    public $keyType = "string";

    /**
     * Is force generate uuid
     *
     * @var bool
     */
    public $forceGenerateUuid = true;

    /**
     * Uuid version
     *
     * @var int
     */
    protected $uuidVersion = 4;

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $data) {
            if (
                is_null($data->{$data->getKeyName()}) ||
                $data->forceGenerateUuid()
            ) {
                $data->{$data->getKeyName()} = $data->generateUuid();
            }
        });
    }

    /**
     * @return string
     * @throws Exception
     */
    public function generateUuid()
    {
        if ($this->uuidVersion == 4) {
            return RamseyUuid::uuid4()->toString();
        } elseif ($this->uuidVersion == 1) {
            return RamseyUuid::uuid1()->toString();
        }

        throw new Exception(
            "UUID version [{$this->uuidVersion}] not supported."
        );
    }

    /**
     * @return bool
     */
    public function forceGenerateUuid()
    {
        return $this->forceGenerateUuid;
    }
}
