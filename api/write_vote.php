<?php
require("../admin/vote.controller.class.php");

$voteController = new VoteController();

// Get the vote from the POST parameters
$selected_option = $_POST['selected_option'];
$vote_id = $_POST['vote_user_id'];


// Write the vote to a JSON file
$voteController->writeVote($vote_id, $selected_option);
