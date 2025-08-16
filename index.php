<?php
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FinalNti Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        h1 {
            margin-bottom: 30px;
            color: #0d6efd;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #0d6efd;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0b5ed7;
        }
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 30px;
            }
            .btn {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to FinalNti Project</h1>
        <a href="http://localhost/assests/auth/login.php" class="btn">Login</a>
        <a href="http://localhost/assests/auth/register.php" class="btn">Register</a>
    </div>
</body>
</html>



