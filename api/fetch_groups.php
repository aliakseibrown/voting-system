<?php
require("../admin/group.controller.class.php");

$controller = new GroupController();

// Fetch the groups
$groups = $controller->fetchGroups();

// Initialize an empty array to hold the groups data
$data = [];

// Loop through the votes and add them to the data array
foreach ($groups as $group) {
    $users = array_map(function ($user) {
        return [
            'email' => htmlspecialchars($user['email']),
            'proxies' => htmlspecialchars($user['proxies']),
        ];
    }, $group['users']);

    $data[] = [
        'group_name' => htmlspecialchars($group['group_name']),
        'main_proxies' => htmlspecialchars($group['main_proxies']),
        'users' => $users,
        'id' => htmlspecialchars($group['group_id'])
    ];
}

echo json_encode($data);
