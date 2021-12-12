<?php



class User {

    public string $error = '';


    public function getAllUsers(): array {
        global $db;

        return $db->query('SELECT * FROM users')->fetchAll();
    }


    public function getUser($id): array {
        global $db;

        return $db->query('SELECT * FROM users WHERE id = ?', $id)->fetchAll();
    }


    public function login($username, $password) {
        global $db;

        if ($userArr = self::verifyUser($username, $password)) {
            $_SESSION['userID'] = $userArr[0]['id'];
            $_SESSION['userRole'] = $userArr[0]['role'];
            $_SESSION['username'] = $username;

            redirect("index.php");
        } else {
            $this->error = "Incorrect username or password.";
        }
    }


    public function logout() {
        global $session;

        if (isset($_GET['logout'])) {
            $_SESSION = [];
            $session->sessionVarExist();

            redirect("index.php");
        }
    }


    static function verifyUser($username, $password): array {
        global $db;

        return $db->query('SELECT id, role FROM users WHERE username = ? AND password = ?', $username, $password)->fetchAll();
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