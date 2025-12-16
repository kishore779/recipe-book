<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $category = $_POST['category'];
    
    // Handle image upload
    $image_url = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        }
    }

    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO recipes (name, description, ingredients, instructions, category, image_url) 
                              VALUES (:name, :description, :ingredients, :instructions, :category, :image_url)");
        
        // Execute the statement
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':ingredients' => $ingredients,
            ':instructions' => $instructions,
            ':category' => $category,
            ':image_url' => $image_url
        ]);

        header("Location: index.php?message=Recipe added successfully");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}