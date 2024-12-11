<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\UserReviewService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserReviewController extends Controller
{
    use ApiResponse;
    private $userReviewsService;
    public function __construct(UserReviewService $userReviewService)
    {
        $this->userReviewsService = $userReviewService;
    }

    public function homePageIndex()
    {
        try {
            $response = $this->userReviewsService->getFiveUserReviews();
            return $this->success(200, 'getting some random reviews', ['reviews' => $response]);
        } catch (Exception $e) {
            Log::error("UserReviewController::HomePageIndex: " . $e->getMessage());
            return $this->error(500, 'fail to get reviews', $e);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = $this->userReviewsService->getReviews();
            return $this->success(200, 'getting some random reviews', ['reviews' => $response]);
        } catch (Exception $e) {
            Log::error("UserReviewController::HomePageIndex: " . $e->getMessage());
            return $this->error(500, 'fail to get reviews', $e);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
