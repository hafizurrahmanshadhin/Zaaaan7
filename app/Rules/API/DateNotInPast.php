<?php

namespace App\Rules\API;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateNotInPast implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the value is a valid date format
        try {
            $date = Carbon::parse($value);
        } catch (\Exception $e) {
            $fail('The :attribute is not a valid date.');
            return;
        }

        // Ensure the date is not in the past (today is allowed)
        if ($date->isBefore(Carbon::today())) {
            $fail('The :attribute cannot be in the past.');
        }
    }
}
