const recipeGrid = document.getElementById('recipe-grid');
const recipeDetail = document.getElementById('recipe-detail');
const contactSection = document.getElementById('contact-section');

async function fetchRecipes() {
    try {
        const response = await fetch('recipes.php');
        const recipes = await response.json();
        return recipes;
    } catch (error) {
        console.error('Error fetching recipes:', error);
        return [];
    }
}

async function displayRecipes(filteredRecipes) {
    recipeGrid.innerHTML = '';
    filteredRecipes.forEach(recipe => {
        const box = document.createElement('div');
        box.classList.add('recipe-box');
        box.dataset.id = recipe.id;
        box.innerHTML = `
            <div class="img-container">
                <img src="${recipe.image}" alt="${recipe.title}">
            </div>
            <span class="category-tag">${recipe.category || 'other'}</span>
            <div class="recipe-content">
                <h3>${recipe.title}</h3>
                <p>${recipe.description}</p>
            </div>
        `;
        recipeGrid.appendChild(box);
    });
}

async function fetchComments(recipeId) {
    try {
        const response = await fetch(`comments.php?recipe_id=${recipeId}`);
        const comments = await response.json();
        return comments;
    } catch (error) {
        console.error('Error fetching comments:', error);
        return [];
    }
}

async function showDetail(recipe) {
    const comments = await fetchComments(recipe.id);
    const ingredients = recipe.ingredients.split('\n').map(ing => `<li>${ing}</li>`).join('');
    const steps = recipe.steps.split('\n').map(step => `<li>${step}</li>`).join('');
    recipeDetail.innerHTML = `
        <button id="back-button">&larr; Back to Recipes</button>
        <h2>${recipe.title}</h2>
        <p>${recipe.description}</p>
        <img src="${recipe.image}" alt="${recipe.title}">
        <div class="detail-section ingredients">
            <h3>Ingredients:</h3>
            <ul>${ingredients}</ul>
        </div>
        <div class="detail-section instructions">
            <h3>Instructions:</h3>
            <ol>${steps}</ol>
        </div>
        <div class="detail-section comments">
            <h3>Comments:</h3>
            <form id="comment-form" data-recipe-id="${recipe.id}">
                <label for="user_name">Name:</label>
                <input type="text" id="user_name" name="user_name" required>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" required></textarea>
                <button type="submit">Post Comment</button>
            </form>
            <div id="comments-list">
                ${comments.length > 0 ? comments.map(c => `
                    <div class="comment">
                        <p><strong>${c.user_name}</strong> (${new Date(c.date_posted).toLocaleDateString()}):</p>
                        <p>${c.comment}</p>
                    </div>
                `).join('') : '<p>No comments yet.</p>'}
            </div>
        </div>
    `;
    recipeGrid.classList.add('hidden');
    document.querySelector('#search-container').classList.add('hidden');
    contactSection.classList.add('hidden');
    recipeDetail.style.display = 'block';
    window.scrollTo(0, 0);

    document.getElementById('back-button').addEventListener('click', () => {
        recipeDetail.style.display = 'none';
        recipeGrid.classList.remove('hidden');
        document.querySelector('#search-container').classList.remove('hidden');
    });

    document.getElementById('comment-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const recipeId = form.dataset.recipeId;
        const userName = form.user_name.value;
        const comment = form.comment.value;

        try {
            const response = await fetch('comments.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `recipe_id=${recipeId}&user_name=${encodeURIComponent(userName)}&comment=${encodeURIComponent(comment)}`
            });
            const result = await response.json();
            if (result.success) {
                form.reset();
                showDetail(recipe); // Refresh comments
            } else {
                alert('Failed to post comment: ' + result.error);
            }
        } catch (error) {
            alert('Error posting comment: ' + error.message);
        }
    });
}

recipeGrid.addEventListener('click', async (e) => {
    const box = e.target.closest('.recipe-box');
    if (box) {
        const id = box.dataset.id;
        const recipes = await fetchRecipes();
        const recipe = recipes.find(r => r.id == id);
        if (recipe) {
            showDetail(recipe);
        }
    }
});

document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', async (e) => {
        e.preventDefault();
        document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));
        anchor.classList.add('active');

        const href = anchor.getAttribute('href').substring(1);
        if (href === 'contact') {
            recipeGrid.classList.add('hidden');
            recipeDetail.style.display = 'none';
            document.querySelector('#search-container').classList.add('hidden');
            contactSection.classList.remove('hidden');
        } else {
            contactSection.classList.add('hidden');
            recipeGrid.classList.remove('hidden');
            document.querySelector('#search-container').classList.remove('hidden');
            const recipes = await fetchRecipes();
            const filtered = (href === 'all') ? recipes : recipes.filter(r => r.category === href);
            displayRecipes(filtered);
        }
    });
});

document.getElementById('search-input').addEventListener('input', async () => {
    const query = document.getElementById('search-input').value.toLowerCase();
    const recipes = await fetchRecipes();
    const filtered = recipes.filter(recipe => {
        const title = recipe.title.toLowerCase();
        const ingredients = recipe.ingredients.toLowerCase();
        return title.includes(query) || ingredients.includes(query);
    });
    displayRecipes(filtered);
    document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));
    document.querySelector('nav a[href="#all"]').classList.add('active');
});

// Initial load
(async () => {
    const recipes = await fetchRecipes();
    displayRecipes(recipes);
})();