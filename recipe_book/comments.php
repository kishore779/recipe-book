<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = filter_input(INPUT_POST, 'recipe_id', FILTER_VALIDATE_INT);
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    if ($recipe_id && $user_name && $comment) {
        try {
            $stmt = $pdo->prepare("INSERT INTO comments (recipe_id, user_name, comment) VALUES (?, ?, ?)");
            $stmt->execute([$recipe_id, $user_name, $comment]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $recipe_id = filter_input(INPUT_GET, 'recipe_id', FILTER_VALIDATE_INT);
    if ($recipe_id) {
        try {
            $stmt = $pdo->prepare("SELECT user_name, comment, date_posted FROM comments WHERE recipe_id = ? ORDER BY date_posted DESC");
            $stmt->execute([$recipe_id]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($comments);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid recipe ID']);
    }
}
?>