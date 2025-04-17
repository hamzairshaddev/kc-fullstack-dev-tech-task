<?php

use Slim\App;

return function (App $app) {
    $app->get('/', function ($request, $response) {
        $response->getBody()->write("Welcome to the API!");
        return $response;
    });

    $app->get('/categories', \App\Controllers\CategoryController::class . ':getAllCategories');
    $app->get('/categories/{id}', \App\Controllers\CategoryController::class . ':getCategoryById');
    $app->get('/courses', \App\Controllers\CourseController::class . ':getAllCourses');
    $app->get('/courses/{id}', \App\Controllers\CourseController::class . ':getCourseById');

    $app->get('/import-data', function ($request, $response) {
        try {
            // Include and execute the import_data.php script
            require_once __DIR__ . '/../import_data.php';

            $response->getBody()->write(json_encode([
                'status' => 'success',
                'message' => 'Data imported successfully'
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    });
};