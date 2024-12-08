<?php

namespace App\Services\Web\Backend;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class SubCateogryService
{
    public function index($request, $category): JsonResponse
    {
        $query = $category->subCategories()->orderBy('created_at', 'DESC');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        return DataTables::of($query)
            ->addColumn('name', function ($data) {
                    return '
                        <td class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold" style="text-align: center;">
                        ' . $data->name . '
                        </td>';
            })
            ->addColumn('action', function ($data) {
                return $data->id;
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }


    public function store(array $data, $category)
    {
        try {
            $category->subCategories()->create([
                'name' => $data['name']
            ]);
        }catch(Exception $e)
        {
            throw $e;
        }
    }
}
