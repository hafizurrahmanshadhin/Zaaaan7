<?php

namespace App\Services\API;

use App\Helper\Helper;
use App\Models\Address;
use App\Models\FirebaseToken;
use App\Models\SubCategory;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAcceptNotification;
use App\Notifications\TaskRequestNotification;
use App\Traits\PushNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class TaskService
{
    use PushNotification;
    private $user;

    /**
     * Constructor for the class. Initializes the authenticated user.
     *
     * This method retrieves the authenticated user using Laravel's Auth facade
     * and assigns it to the $user property for further use in class methods.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getAllUserTasks(): mixed
    {
        try {
            $status  = request()->query('status', null);
            $perPage = request()->query('per_page', 10);

            // Base query with eager loading
            $query = $this->user->clientTasks()->with(['helper', 'images', 'skill']);

            // Filter based on status
            if ($status === 'process') {
                $query->whereStatus('in process');
            } elseif ($status === 'complete') {
                $query->whereStatus('completed');
            } elseif ($status !== null) {
                throw new UnprocessableEntityHttpException('Unprocessable entry', null, 422);
            }

            // Paginate the results
            $tasks = $query->paginate($perPage);
            return $tasks;
        } catch (UnprocessableEntityHttpException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all tasks assigned to the current user as a helper.
     *
     * @return mixed
     */
    public function getAllHelperTasks(): mixed
    {
        try {
            $perPage = request()->query('per_page', 10);
            $tasks   = $this->user->helperTasks()->where('status', 'accepted')
                ->with(['helper', 'address', 'images', 'skill', 'skill.category'])
                ->paginate($perPage);
            return $tasks;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all completed tasks assigned to the current user as a helper.
     *
     * @return mixed
     */
    public function getAllCompletedHelperTasks(): mixed
    {
        try {
            $perPage = request()->query('per_page', 10);
            $tasks   = $this->user->helperTasks()->where('status', operator: 'completed')
                ->with(['helper', 'address', 'images', 'skill', 'skill.category'])
                ->paginate($perPage);
            return $tasks;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getTask(Task $task): array
    {
        try {
            $task->load(['client', 'helper', 'address']);
            $subCategory = SubCategory::findOrFail($task->sub_category_id);
            $subCategory->load('category');
            return [
                'task'         => $task,
                'sub_category' => $subCategory->name ?? null,
                'category'     => $subCategory?->category?->name ?? null,
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all helper request tasks that are still pending.
     *
     * @return mixed
     */
    public function getAllHelperRequestTasks(): mixed
    {
        try {
            $perPage = request()->query('per_page', 10);
            $tasks   = $this->user->requests()->with(['client', 'address', 'images'])->paginate($perPage);
            return $tasks;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Accept a request for a task and assign the current user as the helper.
     *
     * @param $task
     * @return bool
     */
    public function acceptRequest($task): bool
    {
        try {
            DB::beginTransaction();
            $task->requests()->detach();
            $task->update([
                'helper' => $this->user->id,
                'status' => 'accepted',
            ]);
            // sned notification
            $client = User::findOrFail($task->client);
            $client->notify(new TaskAcceptNotification(Auth::user()));

            // Retrieve Firebase tokens for push notification
            $tokens = FirebaseToken::where('user_id', $client->id)->pluck('token');

            if ($tokens->isNotEmpty()) {
                foreach ($tokens as $token) {
                    $this->sendPushNotification($token, "Task Accepted", "Your task has been accepted by ");
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a new task along with associated images and store them in the database.
     *
     * This method performs the following steps:
     * 1. Starts a database transaction.
     * 2. Creates a new task with the provided credentials (address_id, sub_category_id, description, date, time).
     * 3. Iterates over the provided image files, uploads each image, and associates it with the created task.
     * 4. Commits the transaction if successful.
     * 5. In case of an exception, rolls back the transaction and deletes any uploaded images.
     *
     * @param array $credentials The data required to create the task, including:
     *   - 'address_id' (int): The address associated with the task.
     *   - 'sub_category_id' (int): The sub-category under which the task falls.
     *   - 'description' (string): A detailed description of the task.
     *   - 'date' (string): The date when the task is scheduled.
     *   - 'time' (string): The time when the task is scheduled.
     *   - 'image' (array): An array of image files to be associated with the task.
     *
     * @return array The created task and its associated images.
     *
     * @throws Exception If an error occurs during the task creation or image upload process.
     */
    public function createTaske(array $credentials): array
    {
        $images = [];
        try {
            DB::beginTransaction();
            $task = $this->user->clientTasks()->create([
                'address_id'      => $credentials['address_id'],
                'sub_category_id' => $credentials['sub_category_id'],
                'description'     => $credentials['description'],
                'date'            => $credentials['date'],
                'time'            => $credentials['time'],
            ]);

            foreach ($credentials['image'] as $image) {
                $url = Helper::uploadFile($image, 'task/' . $task->id);
                array_push($images, $task->images()->create([
                    'url' => $url,
                ]));
            }
            DB::commit();
            return ['task' => $task, 'images' => $images];
        } catch (Exception $e) {
            DB::rollBack();
            foreach ($images as $image) {
                $url = Helper::deleteFile($image);
            }
            throw $e;
        }
    }

    public function getExperts()
    {
        try {

            $tasksWithAddressSkill = $this->user->clientTasks()->whereStatus('pending')
                ->select('id', 'address_id', 'sub_category_id')
                ->with(['address:id,latitude,longitude', 'skill:id'])
                ->get();


            $helpers = User::where('role', 'helper')->whereHas('addresses', function ($query) {
                $query->where('is_active', true);
            })->with(['skills' => function ($query) {
                $query->select('sub_categories.id');
            }, 'addresses' => function ($query) {
                $query->select('id', 'user_id', 'latitude', 'longitude')
                    ->where('is_active', true);
            }])->get();

            $helpers->each(function ($helper) {
                $helper->skills->each->makeHidden('pivot');
            });


            $earthRadius = 6371;
            $results = [];

            foreach ($tasksWithAddressSkill as $task) {
                $taskLat = $task->address->latitude;
                $taskLng = $task->address->longitude;
                $taskSkillId = $task->sub_category_id;

                $skill = SubCategory::findOrFail($task->sub_category_id);

                $matchedHelpers = [];

                foreach ($helpers as $helper) {
                    // Check if helper has the required skill
                    $helperSkillIds = $helper->skills->pluck('id')->toArray();
                    if (!in_array($taskSkillId, $helperSkillIds)) {
                        continue; // skip if skill doesn't match
                    }

                    // Now check for distance
                    foreach ($helper->addresses as $address) {
                        $distance = $earthRadius * acos(
                            cos(deg2rad($taskLat)) * cos(deg2rad($address->latitude)) *
                                cos(deg2rad($address->longitude) - deg2rad($taskLng)) +
                                sin(deg2rad($taskLat)) * sin(deg2rad($address->latitude))
                        );

                        if ($distance <= 10) {
                            $matchedHelpers[] = [
                                'id' => $helper->id,
                                'first_name' => $helper->first_name,
                                'last_name' => $helper->last_name,
                                'avatar' => $helper->avatar,
                                'rating' => $helper->avarageRating(),
                                'distance_km' => round($distance, 2),
                                'skill' => $skill->name,
                            ];
                            break;
                        }
                    }
                }

                $results[] = [
                    'task' => [
                        'id' => $task->id,
                        // 'sub_category_id' => $taskSkillId,
                        // 'location' => [
                        //     'latitude' => $taskLat,
                        //     'longitude' => $taskLng
                        // ]
                    ],
                    'helpers' => $matchedHelpers
                ];
            }

            // Output the result
            // return [$tasksWithAddressSkill, $helpers];
            return $results;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteRequest($id)
    {
        try {
            $this->user->requests()->detach($id);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }



    /**
     * Handle the creation of a request for a task by a user.
     *
     * This method checks if a request already exists for a specific task and user. If no request exists,
     * it attaches the user to the task through the `task_requests` pivot table. If a request already exists,
     * it throws an exception indicating that the request already exists.
     *
     * @param array $credentials An associative array containing:
     *     - 'task_id' (int): The ID of the task to which the user is making the request.
     *     - 'user_id' (int): The ID of the user making the request.
     *
     * @return bool Returns `true` if the request was successfully added to the task, `false` otherwise.
     *
     * @throws Exception If the request already exists for the user on the task or if there is an error during
     *         the process. Exception message will specify the reason.
     */
    public function giveRequest(array $credentials): bool
    {
        try {
            DB::beginTransaction();

            Log::info("giveRequest called", ['credentials' => $credentials]);

            $task = Task::findOrFail($credentials['task_id']);
            if ($task->requests()->where('user_id', $credentials['user_id'])->exists()) {
                throw new Exception('Request already exists', 404);
            }

            $task->requests()->attach($credentials['user_id']);

            // Retrieve users: helper (who makes the request) and client (task owner)
            $helper = User::findOrFail($credentials['user_id']);
            $client = User::findOrFail($task->client);

            // Send a database notification (if needed)
            $helper->notify(new TaskRequestNotification($client));

            // Example for notifying the helper
            $tokens = FirebaseToken::where('user_id', $helper->id)->pluck('token');
            Log::info("Retrieved Firebase tokens for client", [
                'client_id' => $client->id,
                'count'     => $tokens->count(),
                'tokens'    => $tokens->toArray(),
            ]);

            Log::info("Retrieved Firebase tokens", ['client_id' => $client->id, 'count' => $tokens->count(), 'tokens' => $tokens->toArray()]);

            if ($tokens->isNotEmpty()) {
                foreach ($tokens as $token) {
                    $this->sendPushNotification($token, "New Task Request", "You have received a new task request from {$helper->first_name} {$helper->last_name}");
                }
            } else {
                Log::warning("No Firebase tokens found for client", ['client_id' => $client->id]);
            }


            // Retrieve Firebase tokens for push notification
            $tokens = FirebaseToken::where('user_id', $helper->id)->pluck('token');

            if ($tokens->isNotEmpty()) {
                foreach ($tokens as $token) {
                    $this->sendPushNotification($token, "New Task Request", "You have received a new task request from ");
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function sendPushNotification($token, $title, $body): void
    {
        try {
            Log::info("sendPushNotification called", [
                'token' => $token,
                'title' => $title,
                'body'  => $body,
            ]);

            // Log the credentials file path and verify it exists
            $credentialsFile = storage_path('app/firebase-auth.json');
            Log::info("Using Firebase credentials file", ['path' => $credentialsFile]);
            if (!file_exists($credentialsFile)) {
                Log::error("Firebase credentials file does not exist", ['path' => $credentialsFile]);
                return;
            }

            // Initialize Firebase Factory
            $factory = (new \Kreait\Firebase\Factory)->withServiceAccount($credentialsFile);
            Log::info("Firebase factory initialized successfully.");

            // Create messaging service
            $messaging = $factory->createMessaging();
            Log::info("Firebase messaging service created.");

            // Create the notification payload
            $notification = \Kreait\Firebase\Messaging\Notification::create($title, $body);
            Log::info("Firebase notification payload created.", ['notification' => $notification]);

            // Create the message targeted to a specific token
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $token)
                ->withNotification($notification);
            Log::info("Firebase CloudMessage created.", ['message' => $message]);

            // Send the push notification
            $result = $messaging->send($message);
            Log::info("Push notification sent successfully.", ['result' => $result, 'token' => $token]);
        } catch (Exception $e) {
            Log::error("Failed to send push notification.", [
                'token' => $token,
                'title' => $title,
                'body'  => $body,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
