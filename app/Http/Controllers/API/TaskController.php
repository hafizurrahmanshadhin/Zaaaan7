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


    /**
     * Handle the task request creation process from the user input.
     *
     * This method is responsible for handling the incoming request to create a task request. It validates the
     * incoming data using the provided `TaskRequestRequest` form request, then delegates the task request
     * logic to the `taskService` by calling `giveRequest`. If the request is successfully processed, a success
     * response is returned. If any error occurs during the process, an error response is returned, and the
     * exception details are logged.
     *
     * @param TaskRequestRequest $taskRequestRequest The validated request object containing the input data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with either a success or error status:
     *     - Success: HTTP status code 200 with a success message.
     *     - Error: HTTP status code 500 with the error message and details.
     *
     * @throws Exception If an error occurs during the request process, an exception is thrown and caught, 
     *         with an error message logged for debugging purposes.
     */
    public function request(TaskRequestRequest $taskRequestRequest)
    {
        try {
            $validatedData = $taskRequestRequest->validated();
            $this->taskService->giveRequest($validatedData);
            return $this->success(200, 'task created successfully', []);
        } catch (Exception $e) {
            Log::error('TaksController::request:' . $e->getMessage());
            return $this->error(500, 'fail to request for task', $e->getMessage());
        }

    }
}
