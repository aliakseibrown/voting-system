<?php
require("../admin/vote.controller.class.php");

$voters_email = $_POST["email"]; // Get the vote ID from the AJAX request

$controller = new VoteController();
$user = $controller->checkVoter($voters_email);

if ($user) {
    unset($user['password']); // Remove the password from the user object
    echo json_encode(['success' => true, 'user' => $user]); // Send the user back to the client
} else {
    echo json_encode(['success' => false]);
}
