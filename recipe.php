<?php include 'includes/header.php'; ?>
<?php require 'db/config.php'; ?>

<?php
if (!isset($_GET['rid'])) {
    echo "<p>Recipe ID not provided.</p>";
    include 'includes/footer.php';
    exit;
}

$rid = (int) $_GET['rid'];
$stmt = $pdo->prepare("SELECT recipes.*, users.username FROM recipes JOIN users ON recipes.uid = users.uid WHERE rid = ?");
$stmt->execute([$rid]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "<p>Recipe not found.</p>";
    include 'includes/footer.php';
    exit;
}

// Set image path or fallback to default
$imagePath = !empty($recipe['image']) ? htmlspecialchars($recipe['image']) : 'images/default.jpg';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow p-4 rounded">
                <!-- Recipe Image -->
                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($recipe['name']) ?>" class="img-fluid rounded mb-4" style="max-height: 300px; object-fit: cover; width: 100%;">

                <h2 class="text-center mb-3"><?= htmlspecialchars($recipe['name']) ?></h2>
                <p class="text-center text-muted mb-1">
                    <strong>Type:</strong> <?= htmlspecialchars($recipe['type']) ?> |
                    <strong>By:</strong> <?= htmlspecialchars($recipe['username']) ?>
                </p>
                <p class="text-center text-muted mb-4">
                    <strong>Cooking Time:</strong> <?= $recipe['cookingtime'] ?> minutes
                </p>

                <h5>Description</h5>
                <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>

                <h5>Ingredients</h5>
                <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>

                <h5>Instructions</h5>
                <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

                <?php if (isset($_SESSION['uid']) && $_SESSION['uid'] == $recipe['uid']): ?>
                    <a href="edit_recipe.php?rid=<?= $recipe['rid'] ?>" class="btn btn-warning mt-3 me-2">✏️ Edit Recipe</a>
                    <a href="delete_recipe.php?rid=<?= $recipe['rid'] ?>" class="btn btn-danger mt-3"
                       onclick="return confirm('Are you sure you want to delete this recipe?');">🗑️ Delete Recipe</a>
                <?php endif; ?>

                <a href="index.php" class="btn btn-secondary mt-3">Back to Recipes</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
