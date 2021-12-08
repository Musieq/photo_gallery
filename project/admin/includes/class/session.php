<?php


class Session {

    private bool $signedIn = false;
    public int $userID;
    public string $userRole;
    public string $username;
    public string $error = '';


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


    public function login($username, $password) {
        global $db;

        $user5 = $db->query('SELECT id, role FROM users WHERE username = ? AND password = ?', $username, $password);
        if ($userArr = $user5->fetchAll()) {
            $_SESSION['userID'] = $userArr[0]['id'];
            $_SESSION['userRole'] = $userArr[0]['role'];
            $_SESSION['username'] = $username;

            redirect("index.php");
        } else {
            $this->error = "Incorrect username or password.";
        }
    }


    public function logout() {
        if (isset($_GET['logout'])) {
            $_SESSION = [];
            $this->sessionVarExist();

            redirect("index.php");
        }
    }


    public function displayError() {
        if ($this->error !== '') {
            ?>
            <div class="alert alert-danger">
                <?=$this->error?>
            </div>
            <?php
            $this->error = '';
        }
    }
}