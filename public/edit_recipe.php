<?php include('../includes/header.php'); ?>
<?php require('../db/config.php'); ?>

<?php
if (!isset($_SESSION['uid']) || !isset($_GET['rid'])) {
    header("Location: index.php");
    exit;
}

$rid = (int)$_GET['rid'];
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE rid = ? AND uid = ?");
$stmt->execute([$rid, $_SESSION['uid']]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "<p>Recipe not found or unauthorized access.</p>";
    include('../includes/footer.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $type = $_POST['type'];
    $cookingtime = (int)$_POST['cookingtime'];
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);

    $stmt = $pdo->prepare("UPDATE recipes SET name=?, description=?, type=?, cookingtime=?, ingredients=?, instructions=? WHERE rid=? AND uid=?");
    $stmt->execute([$name, $description, $type, $cookingtime, $ingredients, $instructions, $rid, $_SESSION['uid']]);
    echo "<p class='text-success'>Recipe updated successfully!</p>";
    $recipe = array_merge($recipe, $_POST); // update local data for form
}
?>

<h2>Edit Recipe</h2>
<form method="POST">
    <div class="mb-3">
        <label>Recipe Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($recipe['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required><?= htmlspecialchars($recipe['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <?php
            $types = ['French', 'Italian', 'Chinese', 'Indian', 'Mexican', 'others'];
            foreach ($types as $type) {
                echo "<option value=\"$type\"" . ($recipe['type'] == $type ? " selected" : "") . ">$type</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Cooking Time (minutes)</label>
        <input type="number" name="cookingtime" class="form-control" value="<?= $recipe['cookingtime'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Ingredients</label>
        <textarea name="ingredients" class="form-control" required><?= htmlspecialchars($recipe['ingredients']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Instructions</label>
        <textarea name="instructions" class="form-control" required><?= htmlspecialchars($recipe['instructions']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Recipe</button>
</form>

<?php include('../includes/footer.php'); ?>

