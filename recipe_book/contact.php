<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            header('Location: index.php?success=Message sent successfully!');
            exit;
        } catch (PDOException $e) {
            header('Location: index.php?error=Failed to send message: ' . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header('Location: index.php?error=Invalid input');
        exit;
    }
}
?>