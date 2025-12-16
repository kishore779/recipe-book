<?php include 'header.php'; ?>
    <div id="search-container">
        <input type="text" id="search-input" placeholder="Search by name or ingredient...">
        <a href="add_recipe.php" class="add-recipe-btn">Add Recipe</a>
    </div>
    
    <nav>
        <a href="#all" class="active">All Recipes</a>
        <a href="#breakfast">Breakfast</a>
        <a href="#lunch">Lunch</a>
        <a href="#dinner">Dinner</a>
        <a href="#dessert">Desserts</a>
        <a href="#snacks">Snacks</a>
        <a href="#contact">Contact</a>
    </nav>
    
    <main>
        <div id="recipe-grid"></div>
        <div id="recipe-detail"></div>
        <div id="contact-section" class="hidden">
            <h2>Contact Us</h2>
            <form id="contact-form" action="contact.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    <script src="script.js" defer></script>
</body>
</html>