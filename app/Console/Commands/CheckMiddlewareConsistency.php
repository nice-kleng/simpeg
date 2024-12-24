<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class CheckMiddlewareConsistency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:check-middleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check middleware consistency across controllers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controllerPath = app_path('Http/Controllers');
        $controllers = File::allFiles($controllerPath);

        $inconsistencies = [];

        foreach ($controllers as $controller) {
            $className = $this->getClassNameFromFile($controller);
            if (!class_exists($className)) {
                continue;
            }

            $reflection = new ReflectionClass($className);
            if (!$reflection->hasMethod('middleware')) {
                $inconsistencies[] = "$className does not have a middleware method";
                continue;
            }

            $middleware = $className::middleware();
            if (empty($middleware)) {
                $inconsistencies[] = "$className has an empty middleware method";
            } else {
                foreach ($middleware as $m) {
                    if (!$m instanceof \Illuminate\Routing\Middleware\SubstituteBindings) {
                        $middlewareString = $this->getMiddlewareString($m);
                        if (strpos($middlewareString, 'permission:') !== 0) {
                            $inconsistencies[] = "$className has a middleware without permission check: $middlewareString";
                        }
                    }
                }
            }
        }

        if (empty($inconsistencies)) {
            $this->info('All controllers have consistent middleware definitions.');
        } else {
            $this->error('Middleware inconsistencies found:');
            foreach ($inconsistencies as $inconsistency) {
                $this->line("- $inconsistency");
            }
            exit(1); // Exit with error code for CI/CD pipelines
        }
    }

    private function getClassNameFromFile($file)
    {
        $contents = file_get_contents($file);
        if (preg_match('/namespace\s+(.+?);/', $contents, $matches)) {
            $namespace = $matches[1];
            $className = $namespace . '\\' . $file->getBasename('.php');
            return $className;
        }
        return null;
    }

    private function getMiddlewareString($middleware)
    {
        if (is_string($middleware)) {
            return $middleware;
        } elseif (is_object($middleware)) {
            if (method_exists($middleware, '__toString')) {
                return (string) $middleware;
            } elseif ($middleware instanceof \Illuminate\Routing\Controllers\Middleware) {
                // Extract the middleware name from the class properties
                $reflection = new \ReflectionClass($middleware);
                $property = $reflection->getProperty('middleware');
                $property->setAccessible(true);
                return $property->getValue($middleware);
            } else {
                return get_class($middleware);
            }
        } else {
            return 'Unknown middleware type';
        }
    }
}
