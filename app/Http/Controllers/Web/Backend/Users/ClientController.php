<?php

namespace App\Http\Controllers\Web\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Web\Backend\User\ClientService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
class ClientController extends Controller
{
    use ApiResponse;
    /**
     * clientService
     * @var ClientService
     */
    private ClientService $clientService;

    /**
     * construct
     * @param \App\Services\Web\Backend\User\ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        try {
            if ($request->ajax()) {
                return $this->clientService->index($request);
            }
            return view('backend.layouts.users.clients.index');
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
            Log::error('Client Delete: ' . $e->getMessage());
            return $this->error(500, 'Failed to delete category');
        }
    }
}
