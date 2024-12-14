<?php

namespace App\Services\API;

use App\Helper\Helper;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserReviewService
{
    private $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }


    /**
     * Retrieves all reviews for the user where they are the client.
     * It fetches the reviews along with any associated images and paginates the results.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Exception If any error occurs during the process, it will be thrown.
     */
    public function getClientsReviews(): mixed
    {
        try {
            Log::info($this->user->id);
            $perPage = request()->query('per_page', 10);
            $reviews = $this->user->clientReviews()->with('images')->paginate($perPage);
            return $reviews;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves all reviews for the user where they are the helper.
     * It fetches the reviews along with any associated images and paginates the results.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Exception If any error occurs during the process, it will be thrown.
     */
    public function getHelperReviews(): mixed
    {
        try {
            Log::info($this->user->id);
            $perPage = request()->query('per_page', 10);
            $reviews = $this->user->helperReviews()->with('images')->paginate($perPage);
            return $reviews;
        } catch (Exception $e) {
            throw $e;
        }
    }



    /**
     * Retrieves a paginated list of reviews for the current user.
     *
     * This method fetches a paginated set of reviews written by the currently authenticated user, 
     * including any associated images, and returns them. The number of reviews per page can be specified 
     * via the `per_page` query parameter (defaults to 10).
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of reviews with images.
     * @throws Exception If there is an error while fetching reviews.
     */
    public function getReviews(): mixed
    {
        try {
            $perPage = request('per_page', 10);

            $reviews = Review::whereUserId($this->user->id)->with('images')->paginate($perPage);
            return $reviews;
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * Stores a new review for a task.
     *
     * This method creates a new review for a specified task, storing the rating (star), comment, 
     * and associated images (if provided). The review is stored within a database transaction to ensure 
     * atomicity. If any errors occur during the process, the transaction is rolled back, and any uploaded 
     * images are deleted.
     *
     * @param array $credentials The review data containing 'task_id', 'star', 'comment', and optionally 'image'.
     * @return array The newly created review and any associated images.
     * @throws Exception If there is an error while creating the review or handling the images.
     */
    public function storeReview(array $credentials): array
    {
        $images = [];
        try {
            DB::beginTransaction();
            $review = Review::create([
                'task_id' => $credentials['task_id'],
                'star' => $credentials['star'],
                'comment' => $credentials['comment'],
            ]);
            if (isset($credentials['image']) && !empty($credentials['image']) && is_array($credentials['image'])) {

                foreach ($credentials['image'] as $image) {
                    $url = Helper::uploadFile($image, 'task/' . $review->id);
                    array_push($images, $review->images()->create([
                        'url' => $url
                    ]));
                }
            }
            DB::commit();
            return ['review' => $review, 'images' => $images];
        } catch (Exception $e) {
            DB::rollBack();
            foreach ($images as $image) {
                $url = Helper::deleteFile($image);
            }
            throw $e;
        }
    }

    public function update()
    {
        //
    }


    public function destroy()
    {
        //
    }
}
