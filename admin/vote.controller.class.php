<?php
session_start();

class VoteController
{
    // Properties
    private $name;
    private $surname;
    private $organization;
    private $description;
    private $vote_id;
    private $voters_email;
    private $voters_list;
    private $admin_id;
    private $voter_proxies_quantity;
    private $organization_proxies_quantity;
    private $date;
    private $options;
    private $voted_for;
    private $voted_voters;
    private $total_voters;
    private $voter_proxies;
    private $admin_session;
    private $votes;
    private $new_vote;

    public $error;
    public $success;

    private $users_storage = __DIR__ . '/../data/users.json';
    private $votes_storage = __DIR__ . '/../data/votes.json';

    // Class methods
    public function __construct()
    {
        if (!file_exists($this->votes_storage)) {
            file_put_contents($this->votes_storage, json_encode([]));
        }
    }

    public function createVote(
        $name,
        $surname,
        $organization,
        $description,
        $admin_session,
        $voter_proxies_quantity = 0,
        $organization_proxies_quantity = 0,
        $options = [],
        $voters_list = []

    ) {
        $none = 'None';
        $this->name = empty($name) ? $none : $name;
        $this->surname = empty($surname) ? $none : $surname;
        $this->organization = empty($organization) ? $none : $organization;
        $this->description = empty($description) ? $none : $description;
        $this->vote_id = uniqid();
        $this->admin_session = $admin_session;
        $this->date = date("Y-m-d H:i:s");
        $this->options = $options;
        $this->voters_list = $voters_list;

        $this->votes = json_decode(file_get_contents($this->votes_storage), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to parse votes_storage: ' . json_last_error_msg());
        }

        $this->voter_proxies_quantity = empty($voter_proxies_quantity) ? 0 : $voter_proxies_quantity;
        $this->organization_proxies_quantity = empty($organization_proxies_quantity) ? 0 : $organization_proxies_quantity;
        $this->new_vote = [
            'vote_id' => $this->vote_id,
            'creator' => [
                'admin_name' => $this->admin_session['name'],
                'admin_surname' => $this->admin_session['surname'],
                'admin_email' => $this->admin_session['email'],
                'admin_id' => $this->admin_session['id']
            ],
            'voter_proxies_quantity' => $this->voter_proxies_quantity,
            'organization_proxies_quantity' => $this->organization_proxies_quantity,
            'name' => $this->name,
            'surname' => $this->surname,
            'organization' => $this->organization,
            'options' => $this->options,
            'description' => $this->description,
            'date' => $this->date,
            'voters' => $this->voters_list
        ];
        $this->votes[] = $this->new_vote;
        if (file_put_contents($this->votes_storage, json_encode($this->votes)) === false) {
            throw new Exception('Failed to write to votes_storage');
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $this->success = "Successful";
        return $this;
    }

    public function editOptions($vote_id, $new_options)
    {
        // Load the votes
        $votes = json_decode(file_get_contents($this->votes_storage), true);

        // Find the vote with the matching vote_id
        foreach ($votes as &$vote) {
            if ($vote['vote_id'] == $vote_id) {
                // Update the options
                $vote['options'] = $new_options;

                // Save the votes back to the storage
                file_put_contents($this->votes_storage, json_encode($votes));

                return;
            }
        }

        echo "Vote not found.";
    }
    public function checkVoter($voters_email)
    {
        $users = json_decode(file_get_contents($this->users_storage), true);
        // Check if the email exists in the JSON file
        foreach ($users as $item) {
            if ($item['email'] == $voters_email) {
                // The email exists in the JSON file, return the user
                return $item;
            }
        }
    }

    public function deleteVote($vote_id)
    {
        // Load the votes
        $votes = json_decode(file_get_contents($this->votes_storage), true);

        // Find the vote with the matching vote_id
        foreach ($votes as $key => $vote) {
            if ($vote['vote_id'] == $vote_id) {
                // Remove the vote
                unset($votes[$key]);

                // $votes = array_values($votes);

                // Save the votes back to the storage
                file_put_contents($this->votes_storage, json_encode($votes));

                return;
            }
        }

        echo "Vote not found.";
    }

    public function fetchVotes()
    {

        $admin_email = $_SESSION['email'];

        // Read the JSON file
        $json = file_get_contents($this->votes_storage);
        $data = json_decode($json, true);

        // Filter the votes created by the logged in user
        $votes = array_filter($data, function ($vote) use ($admin_email) {
            return $vote['creator']['admin_email'] == $admin_email;
        });

        return $votes;
    }
    public function getVoteById($voteId)
    {
        // var_dump($voteId);
        // Load the votes from the JSON file
        $json = file_get_contents($this->votes_storage);
        $votes = json_decode($json, true);

        // Find the vote with the given ID
        foreach ($votes as $vote) {
            if ($vote['vote_id'] == $voteId) {
                return $vote;
            }
        }

        // If no vote was found, return null
        return null;
    }
    public function  giveVote($voterEmail, $voteId)
    {
        $votes = json_decode(file_get_contents($this->votes_storage), true);
        foreach ($votes as &$vote) {

            if ($vote['vote_id'] == $voteId) {
                foreach ($vote['voters'] as &$voter) {
                    if ($voter['user_email'] == $voterEmail) {
                        $voter['voted_for'][] = $_SESSION['email'];
                    }
                }
            }
        }
        file_put_contents($this->votes_storage, json_encode($votes));
        return ['success' => true];
    }

    public function hasVoted($voteId)
    {
        // Load the votes from the JSON file
        $user_email = $_SESSION['email'];

        $hasVoted = false;
        $votes = json_decode(file_get_contents($this->votes_storage), true);

        // Iterate over the data
        foreach ($votes as $vote) {
            // Check if this is the correct vote
            if ($vote['vote_id'] == $voteId) {
                // Iterate over the voters
                foreach ($vote['voters'] as $voter) {
                    // Check if this is the correct user
                    if ($voter['user_email'] == $user_email) {
                        // Check if the user has voted
                        if ($voter['voted'] !== "") { // Check if 'voted' is not an empty string
                            $hasVoted = true;
                            error_log(print_r($hasVoted, true));
                            return $hasVoted;
                        }
                    }
                }
            }
        }

        return $hasVoted;
    }

    public function writeVote($voteId, $selectedOption)
    {
        // Load the votes from the JSON file
        $user_email = $_SESSION['email'];

        $json = file_get_contents($this->votes_storage);
        $data = json_decode($json, true);

        foreach ($data as $key => $item) {
            if ($item['vote_id'] === $voteId) { // Check if the vote id matches
                if (isset($item['voters'])) {
                    foreach ($item['voters'] as $voterKey => $voter) {
                        if ($voter['user_email'] === $user_email) {
                            $data[$key]['voters'][$voterKey]['voted'] = $selectedOption;
                        }
                    }
                }
            }
        }
        // Save the votes back to the JSON file
        file_put_contents($this->votes_storage, json_encode($data));
    }

    public function fetchVotresVotes()
    {
        $admin_email = $_SESSION['email'];

        // Read the JSON file
        $json = file_get_contents($this->votes_storage);
        $data = json_decode($json, true);

        // Filter the votes where the logged in user is a voter
        $votes = array_filter($data, function ($vote) use ($admin_email) {
            foreach ($vote['voters'] as $voter) {
                if ($voter['user_email'] == $admin_email) {
                    return true;
                }
            }
            return false;
        });

        return $votes;
    }

    private function checkEmail()
    {

        $votes = json_decode(file_get_contents($this->votes_storage), true);

        // $vote = [
        //     'vote_id' => $this->vote_id,
        //     'creator' => [
        //         'admin_name' => $_SESSION['name'], // Get the name from the session
        //         'admin_surname' => $_SESSION['surname'], // Get the surname from the session
        //         'admin_organization' => $_SESSION['organization'], // Get the organization from the session
        //         'admin_id' => $this->admin_id,
        //     ],
        //     'voter_proxies_quantity' => $this->voter_proxies_quantity,
        //     'organization_proxies_quantity' => $this->organization_proxies_quantity,
        //     'name' => $this->name,
        //     'surname' => $this->surname,
        //     'organization' => $this->organization,
        //     'description' => $this->description,
        //     'date' => $this->date,
        //     'voters' => []
        // ];

        // $this->voters_email = $_POST['email'];
        // foreach ($this->voters_list as $voter) {
        //     if ($voter['email'] == $this->voters_email) {
        //         $this->new_vote['voters'][] = [
        //             'user_id' => $voter['user_id'],
        //             'name' => $voter['name'],
        //             'email' => $voter['email'],
        //             'organization' => $voter['organization'],
        //             'voter_proxies_quantity' => $voter['voter_proxies_quantity'],
        //             'organization_proxies_quantity' => $voter['organization_proxies_quantity'],
        //             'voted_for' => [],
        //             'user_proxies' => [],
        //             'voted' => false
        //         ];
        //     }
        // }

        $votes[] = $this->new_vote;

        if (file_put_contents($this->votes_storage, json_encode($votes))) {
            return $this->success = "Successful";
        } else {
            return $this->error = "Something went wrong, please try again";
        }
        // file_put_contents($this->votes_storage, json_encode($votes));
    }

    public function changeProxiesQuantity($voter_proxies_quantity, $organization_proxies_quantity)
    {
        $votes = json_decode(file_get_contents($this->votes_storage), true);
        foreach ($votes as &$vote) {
            if ($vote['vote_id'] == $this->vote_id) {
                $vote['voter_proxies_quantity'] = $voter_proxies_quantity;
                $vote['organization_proxies_quantity'] = $organization_proxies_quantity;
                file_put_contents($this->votes_storage, json_encode($votes));
                return;
            }
        }
        echo "Vote not found.";
    }
}
