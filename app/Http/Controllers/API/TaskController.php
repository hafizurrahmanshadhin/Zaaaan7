<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateTaskRequest;
use App\Http\Requests\API\TaskRequestRequest;
use App\Services\API\TaskService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use ApiResponse;
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {

    }

    /**
     * Store a newly created task in the database.
     *
     * This method handles the following steps:
     * 1. Validates the incoming request data using the `CreateTaskRequest` class.
     * 2. Passes the validated data to the `taskService->createTaske` method to create the task.
     * 3. Returns a success response with the created task if successful.
     * 4. In case of an exception, logs the error and returns a failure response with the error message.
     *
     * @param CreateTaskRequest $createTaskRequest The validated request containing task creation data.
     *
     * @return  JsonResponse response indicating success or failure of the task creation.
     *
     * @throws Exception If an error occurs during the task creation process.
     */
    public function store(CreateTaskRequest $createTaskRequest): JsonResponse
    {
        try {
            $validatedData = $createTaskRequest->validated();
            $task = $this->taskService->createTaske($validatedData);
            return $this->success(200, 'task created successfully', $task);
        } catch (Exception $e) {
            Log::error('TaksController::store:' . $e->getMessage());
            return $this->error(500, 'fail to store taks', $e->getMessage());
        }
    }


    public function experts()
    {
        try {
            $experts = $this->taskService->getExperts();
            return $this->success(200, 'task created successfully', $experts);
        } catch (Exception $e) {
            Log::error('TaksController::availableExperts:' . $e->getMessage());
            return $this->error(500, 'fail to get available experts', $e->getMessage());
        }
    }


    public function request(TaskRequestRequest $taskRequestRequest)
    {
    //    $validatedData = $taskRequestRequest->validated();

    //    dd($validatedData);
    }
}
