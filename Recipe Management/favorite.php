<?php

session_start();
include '../db.php';

if (isset($_SESSION['user_id']) && isset($_POST['recipe_id'])) {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];

    // Check if the recipe is already in the user's favorites
    $check_sql = "SELECT * FROM user_favorites WHERE user_id = ? AND recipe_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, 'ii', $user_id, $recipe_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) == 0) {
        // Insert favorite if it doesn't already exist
        $sql = "INSERT INTO user_favorites (user_id, recipe_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $recipe_id);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Recipe added to your favorites!";
        } else {
            $message = "Error adding recipe to favorites.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Recipe is already in your favorites.";
    }

    mysqli_stmt_close($check_stmt);
} else {
    $message = "You need to be logged in to add favorites.";
}


header("Location: ../index.php?message=" . urlencode($message));
exit();

?>