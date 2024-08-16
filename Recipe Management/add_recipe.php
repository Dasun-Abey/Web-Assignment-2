<?php
include '../db.php';

$title = $_POST['title'];
$ingredients = $_POST['ingredients'];
$instructions = $_POST['instructions'];
$cuisine = $_POST['cuisine'];
$dietary_preferences = $_POST['dietary_preferences'];


$sql = "INSERT INTO recipes (title, ingredients, instructions, cuisine, dietary_preferences) 
VALUES ('$title', '$ingredients', '$instructions', '$cuisine', '$dietary_preferences')";

$input = mysqli_query($conn,$sql);

if (mysqli_query($conn, $sql)) {
    // Redirect to the form page with a success message
    header('Location: add_recipe_form.php?message=Recipe added successfully!');
} else {
    // Redirect to the form page with an error message
    header('Location: add_recip_form.php?message=Error: Could not add recipe.');
}
mysqli_close($conn);

?>

