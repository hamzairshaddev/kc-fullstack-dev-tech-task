<?php

namespace App\Models;

use App\Services\Database;
use PDO;

class Category
{
    /**
     * Retrieve all categories from the database and convert the data into an array.
     *
     * @param Database $db
     * @return array
     */
    public static function getAll(Database $db): array
    {
        $query = "SELECT c.*, 
                  (SELECT COUNT(*) FROM courses WHERE courses.category_id = c.id) AS count_of_courses 
                  FROM categories c";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert the data into an array
        $categories = [];
        foreach ($result as $row) {
            $categories[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'count_of_courses' => $row['count_of_courses']
            ];
        }

        return $categories;
    }

    /**
     * Retrieve a category by its ID from the database.
     *
     * @param Database $db
     * @param int $id
     * @return array|null
     */
    public static function getById(Database $db, int $id): ?array
    {
        $query = "SELECT c.*, 
                  (SELECT COUNT(*) FROM courses WHERE courses.category_id = c.id) AS count_of_courses 
                  FROM categories c
                  WHERE c.id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'count_of_courses' => $row['count_of_courses']
            ];
        }

        return null;
    }
}
