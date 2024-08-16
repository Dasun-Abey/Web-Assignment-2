<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

    <header>
        <div class="welcome-container">
            <p class="welcome-message">Hi, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>
        <h1>Recipe Manager</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Recipe Management/add_recipe_form.php">Add Recipe</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="../User Management/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php
            if (isset($_GET['message'])) {
                echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
            }
        ?>
        <h2>Add a New Recipe</h2>
        <form action="add_recipe.php" method="post" id="addRecipeForm">
            
            <div class="form-group">
                <label for="title">Recipe Title:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions:</label>
                <textarea id="instructions" name="instructions" rows="6" required></textarea>
            </div>

            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
                <input type="text" id="cuisine" name="cuisine" required>
            </div>

            <div class="form-group">
                <label for="dietary_preferences">Dietary Preferences:</label>
                <input type="text" id="dietary_preferences" name="dietary_preferences">
            </div>

            <button type="submit">Add Recipe</button>
        </form>
    </div>

</body>
</html>
