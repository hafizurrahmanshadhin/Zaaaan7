<?php

namespace App\Services\Web\Backend;

use App\Helper\Helper;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CateogryService
{
    /**
     * Display a listing of categories with optional search filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves all categories, optionally filtered by a search term.
     * The search term can match against category name, cost, or provision fields.
     * The results are returned as a DataTables response with columns for image, name, 
     * cost, provision, and action.
     */
    public function index($request): JsonResponse
    {
        $query = Category::orderBy('created_at', 'DESC');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('cost', 'like', '%' . $searchTerm . '%')
                    ->orWhere('provision', 'like', '%' . $searchTerm . '%');
            });
        }

        return DataTables::of($query)
            ->addColumn('image', function ($data) {
                return $data->url ?? null;
            })
            ->addColumn('name', function ($data) {
                return '
                <td class="product align-middle ps-4">
                    <a class="fw-semibold line-clamp-3 mb-0" href="' . route('admin.category.sub.index', $data->id) . '">' . $data->name . '</a>
                </td>';
            })
            ->addColumn('cost', function ($data) {
                return '
                <td class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                $ ' . $data->cost . '
                </td>';
            })
            ->addColumn('provision', function ($data) {
                return '
                <td class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                $ ' . $data->provision . '
                </td>';
            })
            ->addColumn('action', function ($data) {
                return $data->id;
            })
            ->rawColumns(['image', 'name', 'cost', 'provision', 'action'])
            ->make(true);
    }
    

    /**
     * Store a new category in the database.
     *
     * @param  array  $data  The category data (name, cost, provision, and image)
     * @return void
     *
     * This method creates a new category in the database, uploads the category image,
     * and associates the image with the newly created category. A database transaction 
     * is used to ensure that both the category and image are saved together.
     */
    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $image = Helper::uploadFile($data['image'], 'category');
            $category = Category::create([
                'name' => $data['name'],
                'cost' => $data['cost'],
                'url' => $image,
                'provision' => $data['provision'],
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Helper::deleteFile($image);
            throw $e;
        }
    }


    /**
     * Update an existing category in the database.
     *
     * @param  array  $data      The updated category data (name, cost, provision, and optional image)
     * @param  \App\Models\Category  $category  The category to be updated
     * @return void
     *
     * This method updates the category's name, cost, and provision in the database.
     * If a new image is provided, the old image is deleted, and the new image is uploaded 
     * and associated with the category. A database transaction is used to ensure atomicity.
     */
    public function update(array $data, $category)
    {
        try {
            DB::beginTransaction();
            $category->update([
                'name' => $data['name'],
                'cost' => $data['cost'],
                'provision' => $data['provision'],
            ]);
            if (isset($data['image']) && $data['image']) {
                Helper::deleteFile($category->image->url);
                $image = Helper::uploadFile($data['image'], 'category');
                $category->image()->update([
                    'url' => $image
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
