<?php
class SignupUser
{
    // Properties
    private $username;
    private $raw_password;
    private $name;
    private $surname;
    private $organization;
    private $email;
    private $date;
    private $id;
    private $encrypted_password;
    public $error;
    public $success;
    private $storage = "../data/users.json";
    private $stored_users; // array
    private $new_user; // array

    // Class methods   
    public function __construct($username, $password, $name, $surname, $organization, $email)
    {
        if (!file_exists($this->storage)) {
            file_put_contents($this->storage, json_encode([]));
        }

        $this->username = filter_var(trim($username), FILTER_SANITIZE_STRING);
        $this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
        $this->encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        $this->name = filter_var(trim($name), FILTER_SANITIZE_STRING);
        $this->surname = filter_var(trim($surname), FILTER_SANITIZE_STRING);
        $this->organization = filter_var(trim($organization), FILTER_SANITIZE_STRING);
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->date = date("Y-m-d H:i:s");
        $this->stored_users = json_decode(file_get_contents($this->storage), true);
        $this->id = uniqid();
        $this->new_user = [
            "id" => $this->id,
            "username" => $this->username,
            "password" => $this->encrypted_password,
            "name" => $this->name,
            "surname" => $this->surname,
            "organization" => $this->organization,
            "email" => $this->email,
            "date" => $this->date
        ];
        // Check if the file exists, if not create it

        if ($this->checkFieldValues()) {
            $this->insertUser();
        }
    }
    private function checkFieldValues()
    {
        if (empty($this->username) || empty($this->raw_password)) {
            $this->error = "Both fields are required.";
            return false;
        } else {
            return true;
        }
    } // Checking for empty fields.
    private function usernameExists()
    {
        foreach ($this->stored_users as $user) {
            if ($this->username == $user['username']) {
                $this->error = "Username already taken, please choose a different one.";
                return true;
            }
        }
        return false; // Add this line to return false if the username is not taken.
    } // Checking if the username is taken.
    private function insertUser()
    {
        if ($this->usernameExists() == FALSE) {
            array_push($this->stored_users, $this->new_user);
            if (file_put_contents($this->storage, json_encode($this->stored_users))) {
                return $this->success = "Successful";
            } else {
                return $this->error = "Something went wrong, please try again";
            }
        }
    } // Insert the user in the JSON file.
}
