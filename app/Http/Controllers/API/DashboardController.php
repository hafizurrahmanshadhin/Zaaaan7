<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\DashboardService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    use ApiResponse;
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }


    /**
     * Display the dashboard view.
     *
     * This method handles the request to view the dashboard. It calls the `show()` method
     * of the `dashboardService` to retrieve the dashboard data. If successful, it returns
     * a JSON response with a status code of 200 and the data. In case of an exception,
     * it logs the error and returns a JSON response with a 500 status code.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        try {
            $response = $this->dashboardService->show();
            return $this->success(200, 'success', $response);
        } catch (Exception $e) {
            Log::error('DashboardController::view', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        } 
    }
}
