<?php

if (session_status() === PHP_SESSION_NONE) {
    
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/assests/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assests/includes/functions.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: /assests/auth/login.php");
    exit();
}


try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $db->prepare("SELECT * FROM categories WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .container {
            margin-top: 30px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .action-btns {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assests/includes/navbar.php'; ?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Categories List</h2>
            <a href="/assests/categories/add.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
        </div>

        <?php if (empty($categories)): ?>
            <div class="alert alert-info">No categories found. Please add your first category.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $index => $category): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($category['name']) ?></td>
                            <td class="action-btns">
                                <a href="/assests/categories/edit.php?id=<?= $category['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                   <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/assests/categories/delete.php?id=<?= $category['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this category?')">
                                   <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
   
        document.querySelectorAll('.btn-outline-danger').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this category?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
