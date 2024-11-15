<?php
require("../admin/vote.controller.class.php");

$vote_id = $_POST['vote_id']; // Get the vote ID from the AJAX request

$controller = new VoteController();

$controller->deleteVote($vote_id);

echo json_encode(['success' => true]); // Send a response back to the client
