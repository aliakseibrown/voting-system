<?php
session_start();
include("../../includes/auth_session.php");
include("../../includes/user_data.php");
require("../vote.controller.class.php");

$currentPage = 'control';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Groups Panel</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <link rel="stylesheet" href="../../assets/css/control.css">
    <link rel="stylesheet" href="../../assets/css/navigation.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/group_panel.js"></script>
</head>

<body class=background-color-gray>
    <?php include '../inc/navigation.php'; ?>
    <div class="parent-container">
        <div id="section-container-1">
            <h2>Available groups</h2>
            <input type="hidden" id="voter-emails" name="voter_emails" value="">
            <button class="login-button" id="create-group" type="button">Create group</button>
            <div id="groups">

            </div>
        </div>
        <div id="section-container-2">
            <!-- <div id="email-list"></div> -->
        </div>
    </div>
</body>

</html>