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
                return $data->image->url ?? null;
            })
            ->addColumn('name', function ($data) {
                return '
                <td class="product align-middle ps-4">
                    <a class="fw-semibold line-clamp-3 mb-0" href="">' . $data->name . '</a>
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


    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $image = Helper::uploadFile($data['image'], 'category');
            $Category = Category::create([
                'name' => $data['name'],
                'cost' => $data['cost'],
                'provision' => $data['provision'],
            ]);

            $Category->image()->create([
                'url' => $image
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Helper::deleteFile($image);
            throw $e;
        }
    }
}
