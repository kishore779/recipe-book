<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, name as title, description, ingredients, instructions as steps, category, image_url as image FROM recipes ORDER BY id DESC");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($recipes);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}