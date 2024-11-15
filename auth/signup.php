<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sign up</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class=background-color-gray>
    <?php
    require("signup.class.php");
    session_start();
    if (isset($_POST['submit-signup'])) {
        $user = new SignupUser(
            $username = $_POST['username'],
            $password = $_POST['password'],
            $name = $_POST['name'],
            $surname = $_POST['surname'],
            $organization = $_POST['organization'],
            $email = $_POST['email'],
        );

        if ($user->success = "Successful") {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='signup.php'>signup</a> again.</p>
                  </div>";
        }
    } else {
    ?>
        <div class="signup-container">
            <form action="" method="post">
                <h2>Sign up</h2>
                <input type="text" class="login-input" name="name" placeholder="Name" required />
                <input type="text" class="login-input" name="surname" placeholder="Surname" required />
                <input type="text" class="login-input" name="organization" placeholder="Organization" required />
                <input type="text" class="login-input" name="username" placeholder="Username" required />
                <input type="text" class="login-input" name="email" placeholder="Email" required>
                <input type="password" class="login-input" name="password" placeholder="Password" required>
                <input type="submit" class="login-button" name="submit-signup" value="Sign up" required>
                <p class='link'>Already have an account? <a href='login.php'>Login</a></p>
            </form>
        </div>
    <?php
    }
    ?>
</body>

</html>