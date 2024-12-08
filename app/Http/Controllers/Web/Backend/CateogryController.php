<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\CategoryRequest;
use App\Models\Category;
use App\Services\Web\Backend\CateogryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CateogryController extends Controller
{

    protected $cateogryService;

    public function __construct(CateogryService $cateogryService)
    {
        $this->cateogryService = $cateogryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.layouts.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $categoryRequest)
    {
        try {
            $validatedData = $categoryRequest->validated();
            $this->cateogryService->store($validatedData);
            return redirect()->route('admin.category.index')->with('t-success', 'category created successfully');
            // return redirect()->back()->with('t-success', 'category created successfully');
        } catch (Exception $e) {
            Log::error('Catagory Store: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Failed to create category');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
