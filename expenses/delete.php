<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/assests/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/assests/includes/functions.php';


redirectIfNotLoggedIn();

$userId = $_SESSION['user_id'];
$expenseId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$expenseStmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ? AND user_id = ?");
$expenseStmt->execute([$expenseId, $userId]);
$expense = $expenseStmt->fetch();

if (!$expense) {
    header('Location: /assests/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteStmt = $pdo->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
    $deleteStmt->execute([$expenseId, $userId]);
    
    header('Location: /assests/expenses/view.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/assests/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Are you sure you want to delete this expense?</h5>
                    <p class="text-muted">Amount: <?php echo number_format($expense['amount'], 2); ?> EGP</p>
                    <form method="POST">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <a href="/assests/expenses/view.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

