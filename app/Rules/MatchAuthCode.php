<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MatchAuthCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // dd($attribute,$value,Hash::make($value));
        if ($attribute == "authCode") {
            return Hash::check($value, Config('response_format.AuthCode'));
        }
        if ($attribute == "Token") {
            return Hash::check($value, Config('response_format.Token'));
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'AuthCode Do not match. Please enter valid auth Code';
    }
}
