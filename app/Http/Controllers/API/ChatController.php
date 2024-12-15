<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    use ApiResponse;
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
