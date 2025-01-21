<?php

namespace App\Console\Commands\API;

use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TaskStatusCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            try {
                $now = Carbon::now();
                Task::where('status', 'accepted')
                    ->whereRaw("CONCAT(date, ' ', time) <= ?", [$now->toDateTimeString()])
                    ->update(['status' => 'in process']);
                Log::info('Status Updated');

                Task::where('status', 'pending')
                    ->whereRaw("CONCAT(date, ' ', time) <= ?", [$now->toDateTimeString()])
                    ->update(['status' => 'expired']);
            } catch (Exception $e) {
                throw $e;
            }
        }
        catch(Exception $e) {
            Log::error('Error in updating task status', [$e->getMessage()]);
        }
    }
}
