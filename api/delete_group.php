<?php
require("../admin/group.controller.class.php");

$controller = new GroupController();

// Get the ID of the group to delete from the request
$groupId = $_POST['groupId'];

// Delete the group
$controller->deleteGroup($groupId);

echo json_encode(['success' => true]); // Send a response back to the client
