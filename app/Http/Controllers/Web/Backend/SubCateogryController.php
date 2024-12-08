<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\CreateSubCategoryRequest;
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

    public function __construct(SubCateogryService $subCateogryService)
    {
        $this->subCateogryService = $subCateogryService;
    }

    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        return view('backend.layouts.category.sub-categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubCategoryRequest $request, Category $category)
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
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
