<?php
require("../admin/vote.controller.class.php");

$voteController = new VoteController();

// Get the vote from the POST parameters
$vote_id = $_POST['vote_user_id'];


// Write the vote to a JSON file
$hasVoted = $voteController->hasVoted($vote_id);

echo json_encode($hasVoted);
