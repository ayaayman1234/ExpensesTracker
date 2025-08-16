<?php
require_once 'db.php';

function registerUser($username, $email, $password) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $email, $hashedPassword]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function addExpense($userId, $categoryId, $amount, $description, $expenseDate) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO expenses (user_id, category_id, amount, description, expense_date) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$userId, $categoryId, $amount, $description, $expenseDate]);
}

function getUserExpenses($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT e.*, c.name AS category_name 
                           FROM expenses e 
                           LEFT JOIN categories c ON e.category_id = c.id 
                           WHERE e.user_id = ? 
                           ORDER BY e.expense_date DESC, e.amount DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getTotalExpenses($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT SUM(amount) AS total FROM expenses WHERE user_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    return $result['total'] ? $result['total'] : 0;
}

function addCategory($userId, $name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
    return $stmt->execute([$userId, $name]);
}

function getUserCategories($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY name ASC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getCategoryById($categoryId, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ? AND user_id = ?");
    $stmt->execute([$categoryId, $userId]);
    return $stmt->fetch();
}

function updateCategory($categoryId, $userId, $name) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$name, $categoryId, $userId]);
}

function deleteCategory($categoryId, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
    return $stmt->execute([$categoryId, $userId]);
}

function getExpenseById($expenseId, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ? AND user_id = ?");
    $stmt->execute([$expenseId, $userId]);
    return $stmt->fetch();
}

function updateExpense($expenseId, $userId, $categoryId, $amount, $description, $expenseDate) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE expenses SET category_id = ?, amount = ?, description = ?, expense_date = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$categoryId, $amount, $description, $expenseDate, $expenseId, $userId]);
}

function deleteExpense($expenseId, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
    return $stmt->execute([$expenseId, $userId]);
}
?>
