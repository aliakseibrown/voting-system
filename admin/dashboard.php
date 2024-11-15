<?php
session_start();
include("../includes/auth_session.php");
include("../includes/user_data.php");
$currentPage = 'dashboard';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link rel="stylesheet" href="../assets/css/navigation.css">

</head>

<body class=background-color-white>
    <?php include 'inc/navigation.php'; ?>
    <div class="form">
        <!-- <p>Hey, <?php echo $_SESSION['username']; ?>!</p> -->
        <p>Hey, <?php echo $_SESSION['name'] . " " . $_SESSION['surname']; ?>!</p>
        <p>You are now user dashboard page.</p>
        <p><a href="../auth/logout.php">Logout</a></p>
    </div>
</body>

</html>