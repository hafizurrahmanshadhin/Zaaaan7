<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';


    protected $filesystem;



    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $serviceClass = $this->generateServiceClass($name);

        // Define the path to the services directory
        $path = app_path("Services/{$name}.php");

        // Check if the directory exists, if not, create it
        $directory = app_path('Services');
        if (!$this->filesystem->exists($directory)) {
            $this->filesystem->makeDirectory($directory, 0755, true);  // Only create if not exists
        }

        // Check if service class already exists
        if ($this->filesystem->exists($path)) {
            $this->error("Service class {$name} already exists!");
            return;
        }

        // Create the service class file
        $this->filesystem->put($path, $serviceClass);

        $this->info("Service class {$name} created successfully!");
    }



    private function generateServiceClass($name)
    {
        // Split the input string into the directory (namespace) and the class name
        $namespace = str_replace('/', '\\', dirname($name)); // Get the namespace without the class name
        $className = basename($name); // Get the class name from the input string
    
        return "<?php
    
namespace App\\Services\\{$namespace};

class {$className}
{
    // Your service logic goes here
}
";
    }
    
    
    

}
