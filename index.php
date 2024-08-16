<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: User Management/login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="welcome-container">
            <p class="welcome-message">Hi, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>
        <h1>Recipe Manager</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Recipe Management/add_recipe_form.php">Add Recipe</a></li>
                <li><a href="Recipe Management/favorites.php">Favorites</a></li>
                <li><a href="User Management/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <form action="index.php" method="get">
                <input type="text" name="search" placeholder="Search for a recipe..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </section>
        <section>
            <?php
                if (isset($_GET['message'])) {
                    echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
                }
            ?>

            <h2>Recipes</h2>
            <div id="recipe-list">
                <!-- Recipes will be dynamically inserted here -->
                <?php 
                include 'db.php';
                    
                    $search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                    // Modify the SQL query to search for recipes
                    if ($search_query) {
                        $sql = "SELECT * FROM recipes WHERE title LIKE '%$search_query%' OR ingredients LIKE '%$search_query%' OR cuisine LIKE '%$search_query%' OR dietary_preferences LIKE '%$search_query%'";
                    } else {
                        $sql = "SELECT * FROM recipes";
                    }

                    $result_set = mysqli_query($conn,$sql);

                    if (mysqli_num_rows($result_set) > 0) {
                        while ($results = mysqli_fetch_assoc($result_set)) {
                            echo '<div class="recipe">';
                            echo '<h3>' . htmlspecialchars($results['title']) . '</h3>';
                            echo '<p><strong>Ingredients:</strong> ' . nl2br(htmlspecialchars($results['ingredients'])) . '</p>';
                            echo '<p><strong>Instructions:</strong> ' . nl2br(htmlspecialchars($results['instructions'])) . '</p>';
                            echo '<p><strong>Cuisine:</strong> ' . htmlspecialchars($results['cuisine']) . '</p>';
                            echo '<p><strong>Dietary Preferences:</strong> ' . htmlspecialchars($results['dietary_preferences']) . '</p>';
                            
                            // Add to Favorites button
                            echo "<form action='Recipe Management/favorite.php' method='post'>";
                            echo "<input type='hidden' name='recipe_id' value='" . $results['id'] . "'>";
                            echo "<button type='submit'>Add to Favorites</button>";
                            echo "</form>";
                    
                            // Delete Recipe button
                            echo "<form action='Recipe Management/delete_recipe.php' method='post' onsubmit='return confirm(\"Are you sure you want to delete this recipe?\");'>";
                            echo "<input type='hidden' name='recipe_id' value='" . $results['id'] . "'>";
                            echo "<button type='submit' class='delete-button'>Delete Recipe</button>";
                            echo "</form>";
                    
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No recipes found.</p>';
                    }
    
                    mysqli_close($conn);
                   
                ?>

                

            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Recipe Manager</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>
