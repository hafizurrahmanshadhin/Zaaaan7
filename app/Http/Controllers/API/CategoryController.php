<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\CategoryService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use ApiResponse;
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * Display a listing of all categories.
     *
     * This method handles the request to retrieve all categories from the 
     * category service and returns them in a success response. If an error
     * occurs, an error response is returned with the exception message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->categoryService->getCategoryes();
            return $this->success(200, 'getting all the categories', ['categories' =>$response['categories']]);
        } catch (Exception $e) {
            Log::error('CategoryController:index ->' . $e->getMessage());
            return $this->error(500, 'failed to get categories', $e->getMessage());
        }

    }


    /**
     * Display the specified category.
     *
     * This method handles the request to retrieve a specific category by 
     * its identifier from the category service and returns it in a success 
     * response. If an error occurs, an error response is returned with the 
     * exception message.
     *
     * @param string $category The identifier of the category to view.
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($category): JsonResponse
    {
        try {
            $response = $this->categoryService->getCategory($category);
            return $this->success(200, 'getting the category', ['category' => $response['category']]);
        } catch (Exception $e) {
            Log::error('CategoryController:index ->' . $e->getMessage());
            return $this->error(500, 'failed to get the category', $e->getMessage());
        }

    }


    /**
     * Display the subcategories of a specific category.
     *
     * This method handles the request to retrieve all subcategories for a 
     * given category and returns them in a success response. If an error 
     * occurs, an error response is returned with the exception message.
     *
     * @param string $category The identifier of the category whose subcategories to retrieve.
     * @return \Illuminate\Http\JsonResponse
     */
    public function subCategories($category): JsonResponse
    {
        try {
            $response = $this->categoryService->getSubCategories($category);
            return $this->success(200, 'getting sub-categories of the category', ['sub_categories' => $response['sub_categories']]);
        } catch (Exception $e) {
            Log::error('CategoryController:index ->' . $e->getMessage());
            return $this->error(500, 'failed to get sub-categories', $e->getMessage());
        }

    }
}
