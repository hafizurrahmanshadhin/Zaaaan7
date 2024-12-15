<?php

namespace App\Services\API;

use App\Helper\Helper;
use App\Models\Address;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService
{
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
                'address_id' => $credentials['address_id'],
                'sub_category_id' => $credentials['sub_category_id'],
                'description' => $credentials['description'],
                'date' => $credentials['date'],
                'time' => $credentials['time'],
            ]);

            foreach ($credentials['image'] as $image) {
                $url = Helper::uploadFile($image, 'task/' . $task->id);
                array_push($images, $task->images()->create([
                    'url' => $url
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

            // Step 1: Get all tasks with their associated address and skill
            $tasksWithAddressSkill = $this->user->clientTasks()
                ->select('id', 'address_id', 'sub_category_id') // Assuming `sub_category_id` is the foreign key in the tasks table
                ->with(['address:id,country,state,city,zip', 'skill:id']) // Assuming `skill` is a relationship that links to SubCategory
                ->get();

            // Step 2: Extract unique address details from the tasks
            $addresses = $tasksWithAddressSkill->pluck('address')->unique(function ($address) {
                return $address->country . $address->state . $address->city . $address->zip;
            });

            // Step 3: For each task, find users whose address and skill match the task's address and skill
            $tasksWithUsers = $tasksWithAddressSkill->map(function ($task) use ($addresses) {
                // Find users whose address and skill match the task's address and skill
                $users = User::whereRole('helper')
                    ->whereHas('addresses', function ($query) use ($task) {
                        $query->where('country', $task->address->country)
                            ->where('state', $task->address->state)
                            ->where('city', $task->address->city)
                            ->where('zip', $task->address->zip);
                    })
                    ->whereHas('skills', function ($query) use ($task) {
                        $query->where('sub_category_id', $task->sub_category_id);
                    })
                    ->get();

                // Only include the task ID and related users
                return [
                    'task_id' => $task->id,
                    'users' => $users
                ];
            });

            // Output the result
            return $tasksWithUsers;


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
            $task = Task::findOrFail($credentials['task_id']);
            if ($task->requests()->where('user_id', $credentials['user_id'])->exists()) {

                throw new Exception('request exist', 404);
            }
            $task->requests()->attach($credentials['user_id']);
            return true;

        } catch (Exception $e) {
            throw $e;
        }
    }
}
