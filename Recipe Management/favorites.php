
<?php
session_start();
include '../db.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the user's favorite recipes
    $sql = "SELECT recipes.* FROM recipes 
            JOIN user_favorites ON recipes.id = user_favorites.recipe_id 
            WHERE user_favorites.user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Recipes</title>
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
                <li><a href="add_recipe_form.php">Add Recipe</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="../User Management/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Your Favorite Recipes</h2>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="recipe">
                        <h3><?= htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Ingredients:</strong> <?= nl2br(htmlspecialchars($row['ingredients'])); ?></p>
                        <p><strong>Instructions:</strong> <?= nl2br(htmlspecialchars($row['instructions'])); ?></p>
                        <p><strong>Cuisine:</strong> <?= htmlspecialchars($row['cuisine']); ?></p>
                        <p><strong>Dietary Preferences:</strong> <?= htmlspecialchars($row['dietary_preferences']); ?></p>
                        <form action="remove_favorite.php" method="post">
                            <input type="hidden" name="recipe_id" value="<?= $row['id']; ?>">
                            <button type="submit">Remove from Favorites</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You don't have any favorite recipes yet.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Recipe Manager</p>
    </footer>
</body>
</html>
<?php
    mysqli_stmt_close($stmt);
} else {
    echo "You need to be logged in to view your favorites.";
}
?>
