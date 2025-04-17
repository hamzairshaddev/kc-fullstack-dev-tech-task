<?php

namespace App\Models;

use App\Services\Database;

class Course {
    public static function getAll(Database $db)
    {
        $query = "SELECT * FROM courses";
        $stmt = $db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Return data as an associative array
    }

    public static function getById(Database $db, $id)
    {
        $query = "SELECT * FROM courses WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); // Return data as an associative array
    }
}