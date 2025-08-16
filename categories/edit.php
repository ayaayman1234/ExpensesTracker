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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (empty($name)) {
        $error = 'Category name is required';
    } else {
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$name, $categoryId, $userId])) {
            $success = 'Category updated successfully';
            $category['name'] = $name; // update local value
        } else {
            $error = 'Something went wrong';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Edit Category</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($category['name']); ?>">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="view.php" class="btn btn-secondary">Back to Categories</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


