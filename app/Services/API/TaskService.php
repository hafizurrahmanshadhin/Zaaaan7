<?php
    
namespace App\Services\API;

use Illuminate\Support\Facades\Auth;

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


    public function createTaske(array $credentials)
    {
        return 0;
    }
}
