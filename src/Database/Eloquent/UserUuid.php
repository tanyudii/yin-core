<?php

namespace tanyudii\YinCore\Database\Eloquent;

use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Ramsey\Uuid\Uuid as RamseyUuid;

abstract class UserUuid extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

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
