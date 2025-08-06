<?php

namespace App\Http\Controllers\Web\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Web\Backend\User\HelperService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HelperController extends Controller
{
    use ApiResponse;
    private HelperService $helperService;

    /**
     * construct
     * @param \App\Services\Web\Backend\User\HelperService $helperService
     */
    public function __construct(HelperService $helperService)
    {
        $this->helperService = $helperService;
    }

    /**
     * index
     * @param mixed $request
     * @return JsonResponse|RedirectResponse|\Illuminate\Contracts\View\View
     */
     public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        try {
            if ($request->ajax()) {
                return $this->helperService->index($request);
            }
            return view('backend.layouts.users.helpers.index');
        } catch (Exception $e) {
            Log::error('ClientController::index', [$e->getMessage()]);
            return redirect()->back()->with('t-error', 'Something went wrong! Please try again.');
        }
    }


   /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->success(200, 'user deleted successfully');
        } catch (Exception $e) {
            Log::error('Helper Delete: ' . $e->getMessage());
            return $this->error(500, 'Failed to delete category');
        }
    }
}
