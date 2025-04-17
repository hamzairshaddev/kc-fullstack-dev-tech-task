<?php

$host = 'database.cc.localhost';
$db = 'course_catalog';
$user = 'test_user';
$pass = 'test_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Import categories
    $categories = json_decode(file_get_contents('/var/www/html/data/categories.json'), true);
    $stmt = $pdo->prepare("INSERT INTO categories (id, name, parent_id) VALUES (:id, :name, :parent_id)");
    foreach ($categories as $category) {
        $stmt->execute([
            ':id' => $category['id'],
            ':name' => $category['name'],
            ':parent_id' => $category['parent_id'] ?? null,
        ]);
    }

    // Import courses
    $courses = json_decode(file_get_contents('/var/www/html/data/course_list.json'), true);
    $stmt = $pdo->prepare("INSERT INTO courses (id, title, description, image_preview, category_id) VALUES (:id, :title, :description, :image_preview, :category_id)");
    foreach ($courses as $course) {
        $stmt->execute([
            ':id' => $course['course_id'],
            ':title' => $course['title'],
            ':description' => $course['description'],
            ':image_preview' => $course['image_preview'],
            ':category_id' => $course['category_id'],
        ]);
    }

    echo "Data imported successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}