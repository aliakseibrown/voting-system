<?php
require("../admin/vote.controller.class.php");

$controller = new VoteController();

// Fetch the votes
$votes = $controller->fetchVotresVotes();

// Initialize an empty array to hold the vote data
$data = [];

// Loop through the votes and add them to the data array
foreach ($votes as $vote) {
    $data[] = [
        'name' => htmlspecialchars($vote['name']),
        'surname' => htmlspecialchars($vote['surname']),
        'description' => htmlspecialchars($vote['description']),
        'voted_voters' => htmlspecialchars($vote['voted_voters']),
        'total_voters' => htmlspecialchars(count($vote['voters'])),
        'vote_id' => htmlspecialchars($vote['vote_id'])
    ];
}

// Convert the data array to JSON and print it
echo json_encode($data);
