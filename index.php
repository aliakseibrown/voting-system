<?php
session_start();

if (isset($_SESSION['username'])) {
    // User is logged in, redirect to dashboard
    header('Location: admin/dashboard.php');
    exit;
} else {
    // User is not logged in, redirect to signup page
    header('Location: auth/login.php');
    exit;
}
