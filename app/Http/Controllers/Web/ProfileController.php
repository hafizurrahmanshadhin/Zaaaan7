<?php

namespace App\Http\Controllers\Web;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    use AuthorizesRequests;
    protected $user;
    protected $helper;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->helper = new Helper();
    }


    /**
     * Show the form for editing the specified user's profile.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        $compact = [
            'user' => $user,
            'profile' => $profile,
        ];
        return view('backend.layouts.profile.edit', $compact);
    }



    /**
     * Update the specified user's profile information in storage.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        try {
            DB::beginTransaction();
            $this->user->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
            ]);

            $this->user->profile->update([
                'bio' => $validatedData['bio'],
                'company_name' => $validatedData['company_name'],
                'website' => $validatedData['website'],
            ]);

            DB::commit();

            return redirect()->back();

        } catch (Exception $e) {
            Log::error("Profile Update Error: " . $e->getMessage());
            return redirect()->back();
        }
    }



    /**
     * Upload and update the user's avatar image.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp,jfif',
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $avater = $this->helper->uploadFile($request->avatar, 'avatars/' . $this->user->handle, 'image');

            $this->user->update([
                'avatar' => $avater,
            ]);

            return response()->json([
                'success' => true,
                'data' => $avater,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
                'message' => "validation failed",
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }



    /**
     * Remove the specified user from storage and log them out.
     * 
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        // Authorize the action
        $this->authorize('delete', $user);

        try {
            // Delete the user
            $user->delete();

            // If the deleted user is the currently authenticated user, log them out
            Auth::logout();

            return redirect()->route('login')->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            Log::error("User Delete Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while trying to delete the user.');
        }
    }
}
