<?php
session_start();
require 'db/config.php';

if (!isset($_SESSION['uid']) || !isset($_GET['rid'])) {
    // User not logged in or no recipe ID
    header("Location: index.php");
    exit;
}

$rid = (int) $_GET['rid'];

// Fetch the recipe to check ownership
$stmt = $pdo->prepare("SELECT uid FROM recipes WHERE rid = ?");
$stmt->execute([$rid]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "Recipe not found.";
    exit;
}

// Check if the logged-in user is the owner
if ($recipe['uid'] != $_SESSION['uid']) {
    echo "Unauthorized. You can only delete your own recipes.";
    exit;
}

// Delete the recipe
$stmt = $pdo->prepare("DELETE FROM recipes WHERE rid = ?");
$stmt->execute([$rid]);

// Redirect after deletion
header("Location: index.php");
exit;
?>
