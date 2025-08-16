<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

redirectIfNotLoggedIn();

$userId = $_SESSION['user_id'];
$categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$categories = getUserCategories($userId);
$category = null;
foreach ($categories as $c) {
    if ($c['id'] == $categoryId) {
        $category = $c;
        break;
    }
}

if (!$category) {
    header('Location: view.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
    $stmt->execute([$categoryId, $userId]);
    header('Location: view.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title mb-3">Are you sure you want to delete this category?</h5>
                    <p class="text-muted mb-4"><?php echo htmlspecialchars($category['name']); ?></p>
                    <form method="POST">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <a href="view.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
