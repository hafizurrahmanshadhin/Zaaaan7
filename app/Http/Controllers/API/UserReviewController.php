<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateReviewRequest;
use App\Services\API\UserReviewService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
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
     * Retrieve and return reviews where the user is the client.
     * 
     * This method fetches the reviews where the authenticated user is the client of the tasks,
     * by calling the `getClientsReviews()` method from the `UserReviewsService`. The reviews are
     * returned in a paginated format. The response is then wrapped in a success response with a 200
     * HTTP status code if the operation is successful.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response with the client reviews or an error message.
     * @throws \Exception If an error occurs during the process, the exception is logged and returned as an error response.
     */
    public function clientIndex(): JsonResponse
    {
        try {
            $response = $this->userReviewsService->getClientsReviews();
            return $this->success(200, 'getting client reviews', ['reviews' => $response]);
        } catch (Exception $e) {
            Log::error("UserReviewController::clientIndex: " . $e->getMessage());
            return $this->error(500, 'fail to get client reviews', $e->getMessage());
        }
    }


    /**
     * Retrieve and return reviews where the user is the helper.
     * 
     * This method fetches the reviews where the authenticated user is the helper of the tasks,
     * by calling the `getHelperReviews()` method from the `UserReviewsService`. The reviews are
     * returned in a paginated format. The response is then wrapped in a success response with a 200
     * HTTP status code if the operation is successful.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response with the helper reviews or an error message.
     * @throws \Exception If an error occurs during the process, the exception is logged and returned as an error response.
     */
    public function helperIndex(): JsonResponse
    {
        try {
            // $response = $this->userReviewsService->getClientsReviews();
            $response = $this->userReviewsService->getHelperReviews();
            return $this->success(200, 'getting helper reviews', ['reviews' => $response]);
        } catch (Exception $e) {
            Log::error("UserReviewController::helperIndex: " . $e->getMessage());
            return $this->error(500, 'fail to get helper reviews', $e->getMessage());
        }
    }

    /**
     * Stores a new review for a task.
     *
     * This method validates the incoming review data via the `CreateReviewRequest`, then stores the review 
     * using the `userReviewsService`. It returns a JSON response indicating whether the review was successfully 
     * stored or if an error occurred. Any error is logged for further debugging.
     *
     * @param CreateReviewRequest $createReviewRequest The validated review data from the request.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of storing the review.
     * @throws Exception If there is an error while storing the review.
     */
    public function store(CreateReviewRequest $createReviewRequest): JsonResponse
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
