<?php
session_start();
?>

<?php include 'includes/header.php'; ?>
<?php require 'db/config.php'; ?>

<?php
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $type = $_POST['type'];
    $cookingtime = (int)$_POST['cookingtime'];
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $imagePath = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "images/";
        $imageName = basename($_FILES["image"]["name"]);
        $imagePath = $targetDir . time() . "_" . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    if ($name && $description && $type && $cookingtime && $ingredients && $instructions) {
        $stmt = $pdo->prepare("INSERT INTO recipes (name, description, type, cookingtime, ingredients, instructions, image, uid)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $type, $cookingtime, $ingredients, $instructions, $imagePath, $_SESSION['uid']]);
        $message = 'Recipe added successfully!';
    } else {
        $message = 'Please fill in all fields.';
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4 rounded">
                <h3 class="text-center mb-4">🍳 Add a New Recipe</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Recipe Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option>French</option>
                            <option>Italian</option>
                            <option>Chinese</option>
                            <option>Indian</option>
                            <option>Mexican</option>
                            <option>others</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Cooking Time (minutes)</label>
                        <input type="number" name="cookingtime" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Ingredients</label>
                        <textarea name="ingredients" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Instructions</label>
                        <textarea name="instructions" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Recipe Image</label>
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Recipe</button>
                    <?php if ($message): ?>
                        <div class="alert alert-success mt-3"><?= $message ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
