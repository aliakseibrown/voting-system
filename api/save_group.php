<?php
require("../admin/group.controller.class.php");

$groupName = $_POST['group_name'];
$mainProxies = $_POST['main_proxies'];
$users = json_decode($_POST['users'], true);

$controller = new GroupController();
$controller->saveGroup($groupName, $mainProxies, $users);
