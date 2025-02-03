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

            // Subquery to get the latest message for each conversation (sent and received)
            $subQuery = Message::query()
                ->select(
                    DB::raw('LEAST(sender_id, receiver_id) AS participant_1'),
                    DB::raw('GREATEST(sender_id, receiver_id) AS participant_2'),
                    DB::raw('MAX(id) as last_message_id')
                )
                ->where(function ($query) use ($userId) {
                    // This ensures we include both cases where the user is sender or receiver
                    $query->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId);
                })
                ->groupBy(DB::raw('LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)'));

            // Main query to get the last message for each conversation
            $messages = Message::query()
                ->joinSub($subQuery, 'latest_messages', function ($join) {
                    $join->on('messages.id', '=', 'latest_messages.last_message_id');
                })
                ->with('sender:id,avatar,first_name,last_name', 'receiver:id,avatar,first_name,last_name')
                ->orderByDesc('messages.created_at') // Order by latest message
                ->get();

            // Format the `created_at` field for human readability
            $messages = $messages->map(function ($message) {
                if ($message->created_at) {
                    $message->time = Carbon::parse($message->created_at)->diffForHumans();
                }
                return $message;
            });

            return $this->success(200, 'Last message from each conversation retrieved successfully', $messages);
        } catch (Exception $e) {
            Log::error('Error retrieving last message from each conversation: ' . $e->getMessage(), ['exception' => $e]);
            return $this->error(500, 'An error occurred while retrieving the last message from each conversation: ', $e->getMessage());
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
