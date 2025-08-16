<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/assests/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/assests/includes/functions.php';


redirectIfNotLoggedIn();

$userId = $_SESSION['user_id'];
$categories = getUserCategories($userId);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount       = floatval($_POST['amount']);
    $categoryId   = intval($_POST['category_id']);
    $description  = trim($_POST['description']);
    $expenseDate  = $_POST['expense_date'];

    if ($amount <= 0) {
        $error = 'Amount must be more than zero';
    } elseif (empty($expenseDate)) {
        $error = 'Expense date is required';
    } else {
        if (addExpense($userId, $categoryId, $amount, $description, $expenseDate)) {
            header('Location: /assests/dashboard.php');
            exit();
        } else {
            $error = 'Something went wrong while adding the expense';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Expense</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/assests/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0">Add New Expense</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" step="0.01" id="amount" name="amount" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="expense_date" name="expense_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Expense</button>
                            <a href="/assests/dashboard.php" class="btn btn-outline-secondary">Cancel</a>
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

