<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class RouteJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My route json command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routes = $this->generateRoutes();
        $this->writeJson( $routes );
        return;
    }

    public function generateRoutes()
    {
        $routes = [];
        foreach ( Route::getRoutes()->getRoutes() as $route) {
            if ( is_null( $route->getName() ))
                continue;
            if ( isset( $routes[$route->getName()] ))
                $this->comment("Overwriting duplicate named route: " . $route->getName());
            $routes[$route->getName()] = "/" . $route->uri();
        }
        return $routes;
    }

    protected function writeJson( $routes )
    {
        $filename = 'resources/js/routes.json';


        if (!$handle = fopen($filename, 'w')) {
            $this->error( "Cannot open file: $filename" );
            return;
        }

        // Write $somecontent to our opened file.
        if ( fwrite( $handle, json_encode($routes, JSON_PRETTY_PRINT) ) === FALSE) {
            $this->error( "Cannot write to file: $filename" );
            return;
        }

        $this->info("Wrote routes to: $filename");

        fclose($handle);

    }
}
