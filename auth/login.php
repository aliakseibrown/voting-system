<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class=background-color-gray>
    <?php
    require("login.class.php");
    session_start();
    if (isset($_POST['submit_login'])) {
        $user = new LoginUser($_POST['username'], $_POST['password']);
        if (!empty($user->error)) {
            echo "<div class='form'>
                  <h3>{$user->error}</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        } elseif ($user->success == "Successful") {
            $_SESSION['username'] = $_REQUEST['username'];
            header("Location: ../admin/dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Unexpected error occurred.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
    ?>
        <form class="login-container" method="post" name="login">
            <h2>Login</h2>
            <input type="text" class="login-input" name="username" placeholder="Username"><br>
            <input type="password" class="login-input" name="password" placeholder="Password"><br>
            <button type="submit" class="login-button" name="submit_login">Log in</button>
            <p class='link'>Doesn't have an account? <a href='signup.php'>Sign up</a></p>
        </form>
    <?php
    }
    ?>
</body>

</html>