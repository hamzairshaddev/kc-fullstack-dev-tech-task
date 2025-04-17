<?php

namespace App\Controllers;

use App\Models\Course;
use App\Services\Response;
use App\Services\Database;

class CourseController
{
    protected $response;
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->response = new Response();
    }

    public function getAllCourses()
    {
        $courses = Course::getAll($this->database);
        return $this->response->success($courses);
    }

    public function getCourseById($id)
    {
        $course = Course::getById($this->database, $id);
        if ($course) {
            return $this->response->success($course);
        } else {
            return $this->response->error("Course not found", 404);
        }
    }
}