<?php
require("../admin/vote.controller.class.php");

$voteController = new VoteController();

// Get the vote from the POST parameters
$given_voter_email = $_POST['given_voter_email'];
$vote_id = $_POST['vote_it'];

// Write the vote to a JSON file
$success = $voteController->giveVote($given_voter_email, $vote_it);

echo json_encode($success);
