<?php

namespace App\Services\API;

use App\Helper\Helper;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserReviewService
{
    private $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getFiveUserReviews()
    {
        try {
            $reviews = Review::whereUserId($this->user->id)->with('images')->inRandomOrder()->take(5)->get();
            return $reviews;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getReviews()
    {
        try {
            $perPage = request('per_page', 10);

            $reviews = Review::whereUserId($this->user->id)->with('images')->paginate($perPage);
            return $reviews;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function storeReview(array $credentials)
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
