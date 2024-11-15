<?php
session_start();

class GroupController
{
    // Properties
    private $admin_id;
    private $group_id;
    private $group_name;
    private $main_proxies;
    private $users;

    //Class methods
    private $groups_storage = __DIR__ . '/../data/groups.json';

    public function __construct()
    {
        if (!file_exists($this->groups_storage)) {
            file_put_contents($this->groups_storage, json_encode([]));
        }
    }

    public function saveGroup($groupName, $mainProxies, $users)
    {
        $none = 'None';
        $this->group_name = empty($groupName) ? $none : $groupName;
        $this->main_proxies = empty($mainProxies) ? 0 : $mainProxies;
        $this->admin_id = $_SESSION['id'];;
        $this->users = $users;

        $data = [
            'group_id' => uniqid(), // Generate a unique ID
            'admin_id' => $this->admin_id,
            'group_name' => $this->group_name,
            'main_proxies' => $this->main_proxies,
            'users' => $this->users
        ];

        $json = file_get_contents($this->groups_storage);
        $groups = json_decode($json, true);
        $groups[] = $data; // Add the new group to the array

        file_put_contents($this->groups_storage, json_encode($groups));
    }

    public function fetchGroups()
    {
        $admin_id = $_SESSION['id'];


        $json = file_get_contents($this->groups_storage);
        $groups = json_decode($json, true);

        $adminGroups = array_filter($groups, function ($group) use ($admin_id) {
            return $group['admin_id'] === $admin_id;
        });
        error_log(print_r($adminGroups, true));

        return $adminGroups;
    }

    public function deleteGroup($groupId)
    {
        $json = file_get_contents($this->groups_storage);
        $groups = json_decode($json, true);

        foreach ($groups as $index => $group) {
            if ($group['id'] === $groupId) {
                unset($groups[$index]);
                break;
            }
        }

        // Re-index the array and save it back to the file
        $groups = array_values($groups);
        file_put_contents($this->groups_storage, json_encode($groups));
    }
}
