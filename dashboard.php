<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

redirectIfNotLoggedIn();

$userId = $_SESSION['user_id'];
$expenses      = getUserExpenses($userId);
$totalExpenses = getTotalExpenses($userId);
$categories    = getUserCategories($userId);

$error = '';
$success = '';

// Handle Add Expense form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_expense'])) {
    $amount       = floatval($_POST['amount']);
    $categoryId   = intval($_POST['category_id']);
    $description  = trim($_POST['description']);
    $expenseDate  = $_POST['expense_date'];

    if ($amount <= 0) {
        $error = 'Amount must be greater than zero';
    } else {
        if (addExpense($userId, $categoryId, $amount, $description, $expenseDate)) {
            $success = 'Expense added successfully';
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'Something went wrong while adding expense';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        <div>
            <span class="h4 text-danger">
                Total: <?php echo number_format($totalExpenses, 2); ?> EGP
            </span>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Add Expense Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Expense</div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="add_expense" value="1">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="number" step="0.01" class="form-control" name="amount" placeholder="Amount" required>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" name="expense_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="description" placeholder="Description (optional)">
                    </div>
                </div>
                <div class="mt-3 d-grid">
                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Expenses Table -->
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
                                <a href="expenses/edit.php?id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="expenses/delete.php?id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Categories Management -->
    <div class="mt-4">
        <a href="categories/add.php" class="btn btn-success">Add New Category</a>
        <a href="categories/view.php" class="btn btn-secondary">View Categories</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
