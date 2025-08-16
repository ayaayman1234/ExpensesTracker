<!-- /assests/includes/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/assests/dashboard.php">MyExpenses</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/assests/dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/assests/expenses/view.php">Expenses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/assests/categories/view.php">Categories</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item">
        <li class="nav-item d-flex align-items-center me-3">
    <span class="navbar-text mb-0">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
</li>

          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="/assests/auth/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
