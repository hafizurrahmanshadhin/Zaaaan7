<?php

namespace App\Rules\Web\Backend;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueSubCategoryName implements ValidationRule
{
    protected $categoryId;
    protected $subCategoryId;

    // Constructor to receive the category_id and optional sub-category id (for updates)
    public function __construct($categoryId, $subCategoryId = null)
    {
        $this->categoryId = $categoryId;
        $this->subCategoryId = $subCategoryId;
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

        // If a sub-category ID is passed (for updates), ignore that specific sub-category
        if ($this->subCategoryId) {
            $query->where('id', '!=', $this->subCategoryId);
        }

        // If a record with the same name exists, trigger the validation failure
        if ($query->exists()) {
            $fail('The sub-category name has already been taken under this category.');
        }
    }
}
