<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\CreateCategoryRequest;
use App\Http\Requests\Web\Backend\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Web\Backend\CateogryService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CateogryController extends Controller
{
    use ApiResponse;
    protected $cateogryService;


    /**
     * Constructor to initialize the CategoryService dependency.
     *
     * @param  CateogryService  $categoryService
     * @return void
     *
     * This constructor method injects an instance of the CategoryService class 
     * into the controller. The injected service is then available for use 
     * in all methods of the controller, allowing you to manage category-related 
     * operations, such as storing, updating, and fetching categories.
     */
    public function __construct(CateogryService $cateogryService)
    {
        $this->cateogryService = $cateogryService;
    }

    /**
     * Handle the display of categories or AJAX requests for category data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * This method handles the display of the category index page and serves category data 
     * for AJAX requests. If the request is an AJAX call, it fetches category data using 
     * the category service. Otherwise, it returns the regular category index view.
     */
    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        try {
            if ($request->ajax()) {
                return $this->cateogryService->index($request);
            }
            return view('backend.layouts.category.index');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     *
     * This method returns the view for creating a new category.
     */
    public function create(): View
    {
        return view('backend.layouts.category.create');
    }


    /**
     * Store a newly created category in the database.
     *
     * @param  CreateCategoryRequest  $categoryRequest
     * @return \Illuminate\Http\RedirectResponse
     *
     * This method validates the incoming category data, stores the new category using 
     * the category service, and redirects to the category index with a success message.
     */
    public function store(CreateCategoryRequest $categoryRequest): RedirectResponse
    {
        try {
            $validatedData = $categoryRequest->validated();
            $this->cateogryService->store($validatedData);
            return redirect()->route('admin.category.index')->with('t-success', 'category created successfully');
        } catch (Exception $e) {
            Log::error('Catagory Store: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Failed to create category');
        }
    }


    /**
     * Show the form for editing an existing category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     *
     * This method returns the view for editing the specified category.
     * If an error occurs, a 404 error is returned.
     */
    public function edit(Category $category): View
    {
        try {
            return view('backend.layouts.category.edit', compact('category'));
        } catch (Exception $e) {
            abort(404, 'not-found');
        }
    }

    /**
     * Update the specified category in the database.
     *
     * @param  UpdateCategoryRequest  $updateCategoryRequest
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     *
     * This method validates the updated category data, updates the category using 
     * the category service, and redirects to the category index with a success message.
     */
    public function update(UpdateCategoryRequest $updateCategoryRequest, Category $category): RedirectResponse
    {
        try {
            $validatedData = $updateCategoryRequest->validated();
            $this->cateogryService->update($validatedData, $category);
            return redirect()->route('admin.category.index')->with('t-success', 'category updated successfully');
        } catch (Exception $e) {
            Log::error('Catagory Store: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Failed to create category');
        }
    }


    /**
     * Remove the specified category from the database.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     *
     * This method deletes the specified category from the database. If successful, 
     * it returns a success response. If an error occurs, it returns a failure response.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $category->delete();
            return $this->success(200, 'category deleted successfully');
        } catch (Exception $e) {
            Log::error('Category Delete: ' . $e->getMessage());
            return $this->error(500, 'Failed to delete category');
        }
    }
}
