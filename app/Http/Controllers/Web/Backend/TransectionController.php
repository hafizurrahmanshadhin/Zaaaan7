<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Services\Web\Backend\TransectionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransectionController extends Controller
{
    protected TransectionService $transectionService;

    public function __construct(TransectionService $transectionService)
    {
        $this->transectionService = $transectionService;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->transectionService->index($request);
            }
            return view('backend.layouts.transections.index');
        }catch(Exception $e) {
            Log::error("TransectionController::index", [$e->getMessage()]);
            return redirect()->back()->with('t-success', 'Something Went Wrong');
        }
    }
}
