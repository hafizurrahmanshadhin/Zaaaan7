<?php

namespace App\Http\Controllers\Web\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * show
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(User $user)
    {
        try {
            $compact = [
                "user"=> $user
            ];
            return view('backend.layouts.users.common.profile', $compact);
        }catch (Exception $e) {
            Log::error('UserController:show', ['error' => $e->getMessage()]);
            return redirect()->back()->with('t-error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * status
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(User $user)
    {
        try {
            $user->status = !$user->status;
            $user->save();
            return redirect()->back()->with('t-success','Status Updated');
        }catch (Exception $e) {
            Log::error('UserController:status', ['error' => $e->getMessage()]);
            return redirect()->back()->with('t-error', 'Something went wrong! Please try again.');
        }
    }
}
