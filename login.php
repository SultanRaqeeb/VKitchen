<?php include 'includes/header.php'; ?>
<?php require 'db/config.php'; ?>

<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $pdo->prepare("SELECT uid, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Validate credentials
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['username'] = $user['username']; 
        header("Location: index.php");
        exit;
    } else {
        $message = 'Invalid username or password.';
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4 rounded">
                <h3 class="text-center mb-4">🔐 Login</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <?php if ($message): ?>
                        <div class="alert alert-danger mt-3"><?= $message ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
