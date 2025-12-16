<?php
include 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM recipes");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add categories for filtering (based on your original JavaScript data)
    $categories = ['breakfast', 'lunch', 'dinner', 'dessert', 'snacks'];
    foreach ($recipes as &$recipe) {
        $recipe['category'] = $categories[array_rand($categories)]; // Random category for demo
    }
    
    echo json_encode($recipes);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>