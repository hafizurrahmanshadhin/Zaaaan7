<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\CategoryRequest;
use App\Services\Web\Backend\CateogryService;
use Illuminate\Http\Request;

class CateogryController extends Controller
{

    protected $cateogryService;

    public function __construct (CateogryService $cateogryService) {
        $this->cateogryService = $cateogryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $categoryRequest->validated();
        $this->cateogryService->store($validatedData);

        return redirect()->route('backend.categories.index')->with('t-success', 'category created successfully');
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
