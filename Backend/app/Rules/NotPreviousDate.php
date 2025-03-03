<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotPreviousDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        // Compare the provided date with the current date
        return strtotime($value) >= strtotime(now());
    }

    public function message()
    {
        return 'The :attribute must not be a previous date from the current date.';
    }

}
