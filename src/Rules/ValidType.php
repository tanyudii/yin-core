<?php

namespace tanyudii\YinCore\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class ValidType implements Rule
{
    protected $types;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_assoc($this->types)) {
            return array_key_exists($value, $this->types);
        }

        return in_array($value, $this->types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get("The :attribute is invalid.");
    }
}
