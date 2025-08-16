<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: /assests/auth/login.php'); 
        exit();
    }
}


function logout() {
    session_unset();
    session_destroy();
    header('Location: /assests/auth/login.php');
    exit();
}
