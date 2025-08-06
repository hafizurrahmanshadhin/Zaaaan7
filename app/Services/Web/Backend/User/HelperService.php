<?php

namespace App\Services\Web\Backend\User;

use App\Helper\Helper;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HelperService
{
    /**
     * index
     * @param mixed $request
     * @return JsonResponse
     */
    public function index($request): JsonResponse
    {
        try {
            $query = User::where('role', 'helper')->orderBy('created_at', 'DESC');

            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                });
            }

            return DataTables::of($query)
                ->addColumn('image', function ($data) {
                    return $data->avatar ?? null;
                })
                ->addColumn('name', function ($data) {
                    $url = route('admin.user.show', $data->id);

                    return '
                        <td class="product align-middle ps-4">
                            <a class="fw-semibold line-clamp-3 mb-0" href="' . $url . '">' . e($data->first_name . ' ' . $data->last_name) . '</a>
                        </td>';
                })
                ->addColumn('action', function ($data) {
                    return $data->id;
                })
                ->rawColumns(['image', 'name', 'action'])
                ->make(true);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
