<?php



class User {

    public string $error = '';
    public int $insertID;


    public function getAllUsers(): array {
        global $db;

        return $db->query('SELECT * FROM users')->fetchAll();
    }


    public function getUserByID($id): array {
        global $db;

        return $db->query('SELECT * FROM users WHERE id = ?', $id)->fetchAll();
    }


    public function getUserByUsername($username): array {
        global $db;

        return $db->query('SELECT * FROM users WHERE username = ?', $username)->fetchAll();
    }


    public function login($username, $password) {
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


    public function register($username, $password, $email) {
        global $db;
        if (!$this->getUserByUsername($username)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $db->query('INSERT INTO users(username, password, email) VALUES (?, ?, ?)', $username, $passwordHash, $email);

            if ($db->affectedRows() === 1) {
                $this->insertID = $db->lastInsertID();
                $this->login($username, $password);
            }
        } else {
            $this->error = 'Username already taken';
        }
    }


    static function verifyUser($username, $password): array {
        global $db;

        if ($userPasswordArr = $db->query('SELECT password FROM users WHERE username = ?', $username)->fetchAll()) {
            $userPassword = $userPasswordArr[0]['password'];
            if (password_verify($password, $userPassword)) {
                return $db->query('SELECT id, role FROM users WHERE username = ?', $username)->fetchAll();
            }
        }

        return [];
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