<?php
session_start();
include("../../includes/auth_session.php");
include("../../includes/user_data.php");
require("../vote.controller.class.php");

$currentPage = 'votes';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Vote panel</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <link rel="stylesheet" href="../../assets/css/navigation.css">
    <link rel="stylesheet" href="../../assets/css/control.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/votes.js"></script>
</head>

<body class=background-color-white>
    <?php include '../inc/navigation.php'; ?>
    <div class="bar-container">
        <!-- <button class="login-button" id="button-1" type="button">Button 1</button>
        <button class="login-button" id="button-2" type="button">Button 2</button> -->
    </div>

    <div class="collection-container">

    </div>
</body>

</html>