<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateTaskRequest;
use App\Services\API\TaskService;
use App\Traits\ApiResponse;
use Exception;
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

    public function store(CreateTaskRequest $createTaskRequest)
    {
        try{
            $validatedData = $createTaskRequest->validated();
            // $task = $this->taskService->createTaske($validatedData);
            return $this->success(200, 'task created successfully', $task);
        }catch(Exception $e) {
            Log::error('TaksController::store:' . $e->getMessage());
            return $this->error(500, 'fail to store taks', $e->getMessage());
        }
    }
}
