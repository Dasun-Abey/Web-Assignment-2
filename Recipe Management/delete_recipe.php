<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = intval($_POST['recipe_id']);

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // First, delete from the `user_favorites` table
        $sql = "DELETE FROM user_favorites WHERE recipe_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $recipe_id);
        mysqli_stmt_execute($stmt);

        // Then, delete from the `recipes` table
        $sql = "DELETE FROM recipes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $recipe_id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_commit($conn);
            $message = "Recipe deleted successfully!";
        } else {
            throw new Exception("Error: Could not delete recipe.");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $message = $e->getMessage();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect back to the index page with a message
    header("Location: ../index.php?message=" . urlencode($message));
    exit;
}
?>
