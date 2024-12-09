<?php

namespace App\Services\API;

use App\Models\Category;
use App\Models\SubCategory;
use Exception;

class CategoryService
{
    public function __construct()
    {

    }

    /**
     * Retrieve a list of all categories.
     *
     * This method retrieves all categories from the database using the 
     * Category model and returns them in an associative array. If an error 
     * occurs, it will throw an exception to be handled by the caller.
     *
     * @return array
     * @throws \Exception
     */
    public function getCategoryes():array
    {
        try {
            $categories = Category::get();
            return ['categories' => $categories];
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * Retrieve a specific category by its ID.
     *
     * This method retrieves a category from the database using the 
     * Category model based on the provided ID. If the category is not 
     * found, it will throw a ModelNotFoundException. The category data 
     * is returned in an associative array.
     *
     * @param int $id The ID of the category to retrieve.
     * @return array
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function getCategory($id):array
    {
        try {
            $category = Category::findOrFail($id);
            return ['category' => $category];
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * Retrieve subcategories for a specific category.
     *
     * This method retrieves all subcategories associated with a given 
     * category ID from the SubCategory model and returns them in an 
     * associative array. If an error occurs, it will throw an exception.
     *
     * @param int $id The ID of the category to retrieve subcategories for.
     * @return array
     * @throws \Exception
     */
    public function getSubCategories($id):array
    {
        try {
            $subCategoryes = SubCategory::whereCategoryId($id)->get();
            return ['sub_categories' => $subCategoryes];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
