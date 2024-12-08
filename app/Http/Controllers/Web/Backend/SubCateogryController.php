<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\CreateSubCategoryRequest;
use App\Http\Requests\Web\Backend\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\Web\Backend\SubCateogryService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SubCateogryController extends Controller
{
    use ApiResponse;
    protected $subCateogryService;

    /**
     * Initialize the controller with the SubCateogryService.
     *
     * @param SubCateogryService $subCateogryService
     */
    public function __construct(SubCateogryService $subCateogryService)
    {
        $this->subCateogryService = $subCateogryService;
    }

    /**
     * Display a listing of the sub-categories.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, Category $category): View|JsonResponse|RedirectResponse
    {
        try {
            if ($request->ajax()) {
                return $this->subCateogryService->index($request, $category);
            }
            return view('backend.layouts.category.sub-categories.index', compact('category'));
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * Show the form for creating a new sub-category.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\View\View
     */
    public function create(Category $category)
    {
        return view('backend.layouts.category.sub-categories.create', compact('category'));
    }

    /**
     * Store a newly created sub-category in the database.
     *
     * @param CreateSubCategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSubCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $validatedData = $request->validated();
            $this->subCateogryService->store($validatedData, $category);
            return redirect()->route('admin.category.sub.index', ['category' => $category->id])->with('t-success', 'Sub category created successfully');
        } catch (Exception $e) {
            Log::error('Sub Category Store: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Failed to create sub category');
        }
    }


    /**
     * Show the form for editing the specified sub-category.
     *
     * @param \App\Models\Category $category
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\View\View
     */
    public function edit(Category $category, SubCategory $subCategory): View
    {
        return view('backend.layouts.category.sub-categories.edit', compact('category', 'subCategory'));
    }

    /**
     * Update the specified sub-category in the database.
     *
     * @param UpdateSubCategoryRequest $request
     * @param \App\Models\Category $category
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSubCategoryRequest $request, Category $category, SubCategory $subCategory): RedirectResponse
    {
        try {
            $validatedData = $request->validated();
            $subCategory->update($validatedData);
            return redirect()->route('admin.category.sub.index', ['category' => $category->id])->with('t-success', 'Sub category created successfully');
        } catch (Exception $e) {
            Log::error('Sub Category Store: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Failed to create sub category');
        }
    }

    /**
     * Remove the specified sub-category from the database.
     *
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SubCategory $subCategory): JsonResponse
    {
        try {
            $subCategory->delete();
            return $this->success(200, 'category deleted successfully');
        } catch (Exception $e) {
            Log::error('Category Delete: ' . $e->getMessage());
            return $this->error(500, 'Failed to delete category');
        }
    }
}
