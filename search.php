<?php include('includes/header.php'); ?>
<?php require('db/config.php'); ?>

<h2>Search Results</h2>

<?php
$query = $_GET['query'] ?? '';
$query = "%$query%";

$stmt = $pdo->prepare("SELECT rid, name, type, description FROM recipes WHERE name LIKE ? OR type LIKE ?");
$stmt->execute([$query, $query]);

if ($stmt->rowCount() === 0) {
    echo "<p>No recipes found matching your search.</p>";
} else {
    echo '<div class="row">';
    while ($row = $stmt->fetch()):
    ?>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5><?= htmlspecialchars($row['name']) ?></h5>
                    <h6><?= htmlspecialchars($row['type']) ?></h6>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                    <a href="recipe.php?rid=<?= $row['rid'] ?>" class="btn btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>
    <?php endwhile;
    echo '</div>';
}
?>

<?php include('includes/footer.php'); ?>
