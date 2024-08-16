<?php
session_start();
include '../db.php';

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $recipe_id = intval($_POST['recipe_id']); // Sanitize input

    // Remove the recipe from the user's favorites
    $sql = "DELETE FROM user_favorites WHERE user_id = ? AND recipe_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $recipe_id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: favorites.php'); // Redirect back to favorites page
        exit;
    } else {
        echo "Error removing favorite: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
