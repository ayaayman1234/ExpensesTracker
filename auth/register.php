<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validation checks
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required';
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    }
    elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    }
    // Password constraints
    elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long';
    }
    elseif (!preg_match('/[A-Z]/', $password)) {
        $error = 'Password must contain at least one uppercase letter';
    }
    elseif (!preg_match('/[a-z]/', $password)) {
        $error = 'Password must contain at least one lowercase letter';
    }
    elseif (!preg_match('/[0-9]/', $password)) {
        $error = 'Password must contain at least one number';
    }
    elseif (!preg_match('/[\W]/', $password)) {
        $error = 'Password must contain at least one special character';
    }
    else {
        // تحقق من وجود البريد الإلكتروني مسبقًا
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error = 'This email is already registered';
        } else {
            // تشفير كلمة المرور
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // تسجيل المستخدم الجديد
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                $success = 'Registration successful. You can <a href="login.php">login</a> now.';
            } else {
                $error = 'An error occurred during registration.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.92);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .auth-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
            color: #0d6efd;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }
        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        .input-group {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2 class="auth-title"><i class="fas fa-user-plus me-2"></i>Register</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required 
                           placeholder="Choose a username">
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required 
                           placeholder="Enter your email">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Create password">
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="toggleIconPassword"></i>
                        </span>
                    </div>
                    <div class="password-requirements">
                        <small>Password must contain: 8+ chars, uppercase, lowercase, number, special char</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                               placeholder="Confirm password">
                        <span class="password-toggle" onclick="togglePassword('confirm_password')">
                            <i class="fas fa-eye" id="toggleIconConfirm"></i>
                        </span>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-user-plus me-2"></i>Register
                </button>
                
                <div class="mt-3 text-center">
                    Already have an account? <a href="login.php" class="text-decoration-none">Login here</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(`toggleIcon${fieldId === 'password' ? 'Password' : 'Confirm'}`);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
