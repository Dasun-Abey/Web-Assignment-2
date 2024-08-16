<?php

include '../db.php';

$search = $_GET['search'];
$filter = $_GET['filter'];

$sql = "SELECT * FROM recipes WHERE title LIKE ?;
$params = ["%$search%";

if ($filter) {
    $sql .= " AND dietary_preferences = ?";
    $params[] = $filter;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$recipes = $stmt->fetchAll();

foreach ($recipes as $recipe) {
    echo "<h2>" . htmlspecialchars($recipe['title']) . "</h2>";
    echo "<p>" . htmlspecialchars($recipe['ingredients']) . "</p>";
    echo "<p>" . htmlspecialchars($recipe['instructions']) . "</p>";
    // Add other fields as needed
}

?>