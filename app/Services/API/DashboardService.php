<?php

namespace App\Services\API;

use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function show(): array
    {
        try {
            $userTransections = Transaction::where('helper', $this->user->id);
            $totalEarning = $userTransections->sum('amount');
            $weekEarning = $userTransections->where('created_at', '>=', Carbon::now()->subDays(7))->sum('amount');
            return [
                'totalEarn' => $totalEarning - ($totalEarning * 20 / 100),
                'weeklyEarn' => $weekEarning - ($weekEarning * 20 / 100),
                'rating' =>  $this->user->avarageRating(),
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
