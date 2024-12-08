<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueSubCategoryName implements ValidationRule
{
    protected $categoryId;

    // Constructor to receive the category_id
    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table('sub_categories')
            ->where('category_id', $this->categoryId)
            ->where('name', $value);

        // If a record with the same name exists, trigger the validation failure
        if ($query->exists()) {
            $fail('The sub-category name has already been taken under this category.');
        }
    }
}
