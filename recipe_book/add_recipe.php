<?php include 'header.php'; ?>
    <div class="container">
        <h1>Add New Recipe</h1>
        <form action="process_recipe.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Recipe Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" required></textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions:</label>
                <textarea id="instructions" name="instructions" required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category">
            </div>

            <div class="form-group">
                <label for="image">Recipe Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit">Add Recipe</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>