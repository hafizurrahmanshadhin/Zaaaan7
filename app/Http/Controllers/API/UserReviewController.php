<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateReviewRequest;
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



    /**
     * Retrieve and display five random user reviews for the homepage.
     * 
     * This method calls the `getFiveUserReviews` function from the `userReviewsService` to fetch a selection of random reviews. 
     * Upon successful retrieval, it returns the reviews with a success response.
     * In case of failure, it logs the error and returns an appropriate error response.
     * 
     * @return \Illuminate\Http\JsonResponse The success or error response containing the reviews or error message.
     * @throws \Exception If an error occurs during the process of fetching user reviews.
     */
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


    public function store(CreateReviewRequest $createReviewRequest)
    {
        try {
            $validatedData = $createReviewRequest->validated();
            $response = $this->userReviewsService->storeReview($validatedData);
            return $this->success(200, 'review stored', ['reviews' => $response]);
        } catch (Exception $e) {
            Log::error("UserReviewController::store: " . $e->getMessage());
            return $this->error(500, 'fail to store reviews', $e->getMessage());
        }
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
