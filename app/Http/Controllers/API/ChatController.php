<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{

    use ApiResponse;

    /**
     *? Get users with the last message between them and the authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $authUser = $request->user();

            $userId = $authUser->id;

            $subQuery = Message::query()
                ->select('sender_id', DB::raw('MAX(id) as last_message_id'), DB::raw('MAX(created_at) as time'))
                ->where('receiver_id', $userId)
                ->where('sender_id', '!=', $userId)
                ->groupBy('sender_id');

            $messages = Message::query()
                ->joinSub($subQuery, 'latest_messages', function ($join) {
                    $join->on('messages.id', '=', 'latest_messages.last_message_id');
                })
                ->with('sender:id,avatar,first_name,last_name')
                ->orderByDesc('messages.id')
                ->get();

            // Format `created_at` field with Carbon's diffForHumans
            $messages = $messages->map(function ($message) {
                if ($message->time) {
                    $message->time = Carbon::parse($message->time)->diffForHumans();
                }
                return $message;
            });

            return $this->success(200, 'Users with last message retrieved successfully', $messages);
        } catch (Exception $e) {
            Log::error('Error retrieving users with last message: ' . $e->getMessage(), ['exception' => $e]);
            return $this->error(500, 'An error occurred while retrieving users with last message: ', $e->getMessage());
        }
    }


    // public function search($search) {}


    /**
     ** Get messages between the authenticated user and another user
     *
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function getMessages(User $user, Request $request): JsonResponse
    {
        $messages = Message::query()
            ->where(function ($query) use ($user, $request) {
                $query->where('sender_id', $request->user()->id)
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($user, $request) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $request->user()->id);
            })
            ->with([
                // 'sender:id,name,avatar',
                //! 'receiver:id,name,avatar',
            ])
            ->orderBy('id', 'desc')
            ->get();

        return $this->success(200, 'Messages retrieved successfully', $messages);
    }



    /**
     *! Send a message to another user
     *
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $user->id,
            'text' => $request->message,
        ]);

        //* Load the sender's information
        $message->load('sender:id,avatar');

        broadcast(new MessageSent($message))->toOthers();

        return $this->success(200, 'Message sent successfully', $message);
    }
}
