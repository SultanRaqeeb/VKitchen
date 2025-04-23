<?php
session_start();
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
<?php include 'includes/header.php'; ?>
<?php require 'db/config.php'; ?>

<div class="container my-5 pb-5"> 

    <!-- Heading and Search Bar -->
    <div class="row mb-4 align-items-center justify-content-between">
        <div class="col-auto mb-3 mb-lg-0">
            <div class="card px-3 py-2 shadow-sm">
                <h2 class="mb-0">All Recipes</h2>
            </div>
        </div>
        <div class="col-lg-6">
            <form action="search.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Search recipes by name or type" aria-label="Search">
                    <button class="btn btn-black" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recipes -->
    <div class="row g-4">
        <?php
        $stmt = $pdo->query("SELECT rid, name, type, description, image FROM recipes ORDER BY rid DESC");
        while ($row = $stmt->fetch()):
        ?>
        <div class="col-md-4">
            <div class="card h-100">
                <!-- Image -->
                <?php if (!empty($row['image'])): ?>
                    <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 200px; object-fit: cover;">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($row['type']) ?></h6>
                    <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                    <a href="recipe.php?rid=<?= $row['rid'] ?>" class="btn btn-black mt-2">View Recipe</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
