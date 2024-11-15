<?php
session_start();

class LoginUser
{
    // Properties 
    private $username;
    private $password;
    public $error;
    public $success;
    private $storage = "../data/users.json";
    private $stored_users;

    // Class methods
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->stored_users = json_decode(file_get_contents($this->storage), true);
        $this->login();
    }

    private function login()
    {
        foreach ($this->stored_users as $user) {
            if ($user['username'] == $this->username) {
                if (password_verify($this->password, $user['password'])) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $this->success = "Successful";
                    return;
                }
            }
        }
        $this->error = "Wrong username or password";
        return;
    }
}
