<?php

namespace App\Rules\API;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TimeBasedOnDate implements ValidationRule
{
    protected $date;

    /**
     * Create a new rule instance.
     *
     * @param  string  $date
     * @return void
     */
    public function __construct(string $date)
    {
        $this->date = $date;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If the date is today, ensure the time is not in the past
        if (Carbon::parse($this->date)->isToday()) {
            $taskDateTime = Carbon::parse($this->date . ' ' . $value);  // Combine date and time
            if ($taskDateTime->isPast()) {
                $fail('The :attribute must be in the future if the date is today.');
            }
        }
    }
}
