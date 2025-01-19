<?php

namespace App\Services\Web\Backend;

use App\Models\Category;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class TransectionService
{
    public function index($request)
    {
        try {
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
        } catch (Exception $e) {
            throw $e;
        }
    }
}
