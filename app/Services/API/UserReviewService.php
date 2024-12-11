<?php

namespace App\Services\API;

use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function store()
    {
        //
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
