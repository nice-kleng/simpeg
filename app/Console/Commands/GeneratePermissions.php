<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\Middleware;

class GeneratePermissions extends Command
{
    protected $signature = 'permissions:generate';
    protected $description = 'Generate permissions based on controller methods';

    public function handle()
    {
        try {
            $this->info('Starting permission generation...');

            $controllerPath = app_path('Http/Controllers');
            $controllers = File::allFiles($controllerPath);

            foreach ($controllers as $controller) {
                $this->processController($controller);
            }

            $this->info('Permissions generation completed.');
            $this->info('Total permissions: ' . Permission::count());
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }

    private function processController($controller)
    {
        try {
            if (!$controller instanceof \SplFileInfo) {
                $this->warn("Skipping invalid controller file: " . print_r($controller, true));
                return;
            }

            if (!$controller->isFile()) {
                $this->warn("Skipping non-file: " . $controller->getRealPath());
                return;
            }

            $className = $this->getClassNameFromFile($controller);

            $this->info("Processing controller: $className");

            if (!class_exists($className)) {
                $this->warn("Class does not exist: $className");
                return;
            }

            // Skip AuthenticateController
            $excludedControllers = ['AuthenticateController'];
            if (Str::endsWith($className, $excludedControllers)) {
                $this->info("Skipping excluded controller: $className");
                return;
            }

            // Check if the controller has a middleware method
            if (method_exists($className, 'middleware')) {
                $middlewares = $className::middleware();
                $this->processMiddlewares($middlewares);
            } else {
                $this->info("No middleware method found in $className");
            }
        } catch (\Exception $e) {
            $this->error("Error processing controller: " . $controller->getFilename());
            $this->error($e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }

    private function processMiddlewares($middlewares)
    {
        foreach ($middlewares as $middleware) {
            if ($middleware instanceof \Illuminate\Routing\Middleware\SubstituteBindings) {
                continue; // Skip non-permission middlewares
            }

            if ($middleware instanceof \Illuminate\Routing\Controllers\Middleware) {
                $middlewareString = $middleware->middleware;
            } else {
                $middlewareString = (string) $middleware;
            }

            if (strpos($middlewareString, 'permission:') === 0) {
                $permissionNames = substr($middlewareString, 11); // Remove 'permission:' prefix
                $permissionArray = explode('|', $permissionNames); // Split permissions if there are multiple

                foreach ($permissionArray as $permissionName) {
                    $permissionName = trim($permissionName); // Remove any whitespace
                    if (!empty($permissionName)) {
                        $this->createPermissionForMethod($permissionName);
                    }
                }
            }
        }
    }

    private function createPermissionForMethod($permissionName)
    {
        $this->info("Generating permission: $permissionName");

        $existingPermission = Permission::where('name', $permissionName)->first();

        if ($existingPermission) {
            $this->info("Permission already exists: $permissionName (ID: {$existingPermission->id})");
        } else {
            try {
                $newPermission = Permission::create([
                    'name' => $permissionName,
                    'guard_name' => 'web'
                ]);
                $this->info("Created new permission: $permissionName (ID: {$newPermission->id})");
            } catch (\Exception $e) {
                $this->error("Failed to create permission: $permissionName");
                $this->error("Error: " . $e->getMessage());
            }
        }
    }

    private function getClassNameFromFile($file)
    {
        $contents = file_get_contents($file->getRealPath());
        if (preg_match('/namespace\s+(.+?);/', $contents, $matches)) {
            $namespace = $matches[1];
            $className = $file->getBasename('.php');
            return $namespace . '\\' . $className;
        }
        return null;
    }

    // private function generatePermissionName($className, $methodName)
    // {
    //     $controller = class_basename($className);
    //     $controller = str_replace('Controller', '', $controller);
    //     return ucfirst($methodName) . ' ' . ucfirst($controller);
    // }

    // private function shouldSkipMethod($className, $methodName)
    // {
    //     // Daftar method yang dikecualikan untuk setiap controller
    //     $excludedMethods = [
    //         'App\Http\Controllers\UserController' => ['login', 'logout'],
    //         'App\Http\Controllers\HomeController' => ['index'],
    //         // Tambahkan controller dan method lain yang ingin dikecualikan di sini
    //     ];

    //     // Cek apakah class ada dalam daftar yang dikecualikan
    //     if (array_key_exists($className, $excludedMethods)) {
    //         // Cek apakah method ada dalam daftar yang dikecualikan untuk class ini
    //         return in_array($methodName, $excludedMethods[$className]);
    //     }

    //     return false;
    // }
}
