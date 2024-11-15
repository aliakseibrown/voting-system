<?php
require("../admin/vote.controller.class.php");
$voteId = $_POST['options_id']; // Retrieve the voteId from the query parameters
// error_log($voteId);

$voteController = new VoteController();
$vote = $voteController->getVoteById($voteId);

echo json_encode($vote);
