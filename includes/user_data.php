<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Load the JSON file and decode it
    $json = file_get_contents('../data/users.json');
    $users = json_decode($json, true);

    // Loop through the users to find a match
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['surname'] = $user['surname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['organization'] = $user['organization'];
            $_SESSION['user_id'] = $user['id'];
            break;
        }
    }
}
