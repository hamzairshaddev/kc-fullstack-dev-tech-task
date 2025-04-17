<?php

use Slim\Factory\AppFactory;
use App\Middleware\CorsMiddleware;

require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// Add CORS middleware
$app->add(new CorsMiddleware());

// Load routes
(require __DIR__ . '/routes/api.php')($app);

$app->run();