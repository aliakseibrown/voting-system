<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<head>
    <meta charset="utf-8" />
    <title>Creating voting</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <link rel="stylesheet" href="../../assets/css/control.css">
</head>

<body class=background-color-gray>
    <?php
    require("../vote.controller.class.php");
    session_start();
    if (isset($_POST['submit-create-vote'])) {
        $controller = new VoteController();
        // $voters = explode(',', $_POST['voter_emails']);
        $voters = json_decode('[' . $_POST['voter_emails'] . ']', true);
        // $voters = json_decode('[' . $_POST['voter_emails'] . ']', true);
        // $voters = json_decode($_POST['voter_emails'], true);
        $user = $controller->createVote(
            $_POST['name'],
            $_POST['surname'],
            $_POST['organization'],
            $_POST['description'],
            $_SESSION,
            $_POST['voter_proxies_quantity'],
            $_POST['organization_proxies_quantity'],
            $_POST['option'],
            $voters
        );
        if ($user->success == "Successful") {
            echo "<div class='form'>
                  <h3>Your form has been created, you can can see it from the admin panel.</h3><br/>
                  <p class='link'>Click here to <a href='control.php'>go to Control</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='create_vote.php'>Create a vote</a> again.</p>
                  </div>";
        }
    } else {
    ?>
        <div class="vote-container">
            <form action="create_vote.php" method="post">
                <h1>Creating voting</h1>
                <input type="text" class="general-input" name="name" placeholder="Name" />
                <input type="text" class="general-input" name="surname" placeholder="Surname" />
                <input type="text" class="general-input" name="organization" placeholder="Organization" />
                <input type="text" class="general-input" name="description" placeholder="Description" />
                <input type="text" class="general-input" name="voter_proxies_quantity" placeholder="Voter Proxies Quantity" />
                <input type="text" class="general-input" name="organization_proxies_quantity" placeholder="Organization Proxies Quantity" />
                <h2>Options</h2>
                <div id="option-container">
                    <input type="text" class="general-input" name="option[]" placeholder="Option 1" />
                </div>
                <button class="square-button" id="add-option">More options</button>
                <button class="square-button" id="cancel-option">Less options</button>
                <h2>Voters</h2>
                <input type="text" class="general-input" id="email" placeholder="Voter's Email" required />
                <div id="email-list"></div>
                <input type="hidden" id="voter-emails" name="voter_emails" value="">
                <button class="square-button" id="check-voter">Add Voter</button>
                <!-- <button class="square-button" id="more-voters">More Voters</button> -->

                <div class="button-container">
                    <input type="submit" name="submit-create-vote" value="Create Vote" class="general-button" required>
                    <p class='link'><a href='control.php'>Go back</a></p>
                </div>
            </form>
        </div>
        <script src="js/create_vote.js"></script>
    <?php
    }
    ?>
</body>

</html>