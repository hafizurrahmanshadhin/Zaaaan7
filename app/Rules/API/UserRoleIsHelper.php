<?php

namespace App\Rules\API;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserRoleIsHelper implements ValidationRule
{
    protected $userId;

    /**
     * Create a new rule instance.
     *
     * @param  int  $userId
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::find($value);

        if (!$user || $user->role !== 'helper')
        {
            $fail('The selected user is not a helper.!');
        }
    }
}
