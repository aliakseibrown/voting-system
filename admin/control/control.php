<?php
session_start();
include("../../includes/auth_session.php");
include("../../includes/user_data.php");
require("../vote.controller.class.php");

$currentPage = 'control';

// if (isset($_POST['create-vote'])) {
//     header("Location: create_vote.php");
// }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Control panel</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <link rel="stylesheet" href="../../assets/css/navigation.css">
    <link rel="stylesheet" href="../../assets/css/control.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/control.js"></script>
</head>

<body class=background-color-white>
    <?php include '../inc/navigation.php'; ?>
    <div class="bar-container">
        <button class="login-button" id="create-vote" type="button">Create vote</button>
        <button class="login-button" id="show-groups" type="button">Groups panel</button>
        <!-- <form method="post">
            <input type="submit" name="create-vote" value="Create Vote" class="login-button" required>
        </form> -->
    </div>

    <div class="collection-container">

    </div>
</body>

</html>