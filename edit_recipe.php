<?php
session_start();
?>

<?php include 'includes/header.php'; ?>
<?php require 'db/config.php'; ?>

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
    echo "<p>Recipe not found or you're not the owner.</p>";
    include 'includes/footer.php';
    exit;
}

$currentImage = $recipe['image']; // Save current image path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $type = $_POST['type'];
    $cookingtime = (int)$_POST['cookingtime'];
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $newImage = $currentImage;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "images/";
        $imageName = basename($_FILES["image"]["name"]);
        $newImage = $targetDir . time() . "_" . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $newImage);
    }

    // Update recipe with new or existing image path
    $stmt = $pdo->prepare("UPDATE recipes SET name=?, description=?, type=?, cookingtime=?, ingredients=?, instructions=?, image=? WHERE rid=? AND uid=?");
    $stmt->execute([$name, $description, $type, $cookingtime, $ingredients, $instructions, $newImage, $rid, $_SESSION['uid']]);

    echo "<div class='alert alert-success'>Recipe updated!</div>";

    // Refresh recipe array with new inputs
    $recipe = array_merge($recipe, $_POST);
    $recipe['image'] = $newImage;
}
?>

<div class="row justify-content-center my-5">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">✏️ Edit Recipe</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
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
                        <select name="type" class="form-select" required>
                            <?php
                            $types = ['French', 'Italian', 'Chinese', 'Indian', 'Mexican', 'others'];
                            foreach ($types as $t) {
                                echo "<option value=\"$t\"" . ($recipe['type'] == $t ? " selected" : "") . ">$t</option>";
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
                    <div class="mb-3">
                        <label>Current Image</label><br>
                        <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="Current Image" style="max-width: 100%; height: auto; border-radius: 6px; margin-bottom: 10px;">
                        <input type="file" name="image" class="form-control mt-2" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Update Recipe</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
