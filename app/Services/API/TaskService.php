<?php

namespace App\Services\API;

use App\Helper\Helper;
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
    public function createTaske(array $credentials):array
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
}
