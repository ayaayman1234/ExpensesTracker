<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

redirectIfNotLoggedIn();

$userId = $_SESSION['user_id'];
$expenses      = getUserExpenses($userId);
$totalExpenses = getTotalExpenses($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Expenses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Expenses</h2>
        <div class="h4 text-danger">
            Total: <?php echo number_format($totalExpenses, 2); ?> EGP
        </div>
    </div>

    <?php if (empty($expenses)): ?>
        <div class="alert alert-info">No expenses recorded yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?php echo number_format($expense['amount'], 2); ?> EGP</td>
                        <td><?php echo $expense['category_name'] ?? 'Uncategorized'; ?></td>
                        <td><?php echo $expense['expense_date']; ?></td>
                        <td><?php echo $expense['description'] ?? '-'; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="delete.php?id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this expense?')">
                                <i class="bi bi-trash"></i>
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
</body>
</html>

