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


    public function sessionVarExist() {

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


    public function isAdmin(): bool {
        if ($this->isSignedIn()) {
            if ($this->userRole === 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }






}