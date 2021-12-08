<?php


class Session {

    private bool $signedIn = false;
    public int $userID;
    public string $userRole;
    public string $username;


    function __construct() {

        session_start();
        $this->sessionVarExist();
    }


    private function sessionVarExist() {

        if(isset($_SESSION['userID'])) {
            $this->userID = $_SESSION['userID'];
            $this->userRole = $_SESSION['userRole'];
            $this->username = $_SESSION['username'];
            $this->signedIn = true;
        } else {
            unset($this->userID);
            unset($this->userRole);
            unset($this->username);
            $this->signedIn = false;
        }
    }


    public function isSignedIn(): bool {
        return $this->signedIn;
    }

    public function login() {
        global $db;

        $username = 'admin';
        $password = 'admin';

        $user5 = $db->query('SELECT id, role FROM users WHERE username = ? AND password = ?', $username, $password);
        if ($userArr = $user5->fetchAll()) {
            $_SESSION['userID'] = $userArr[0]['id'];
            $_SESSION['userRole'] = $userArr[0]['role'];
            $_SESSION['username'] = $username;
        } else {
            // Wrong credentials
        }
    }


    public function logout() {
        unset($_SESSION);
        $this->sessionVarExist();
    }
}