<?php



class User {

    public function getAllUsers(): array {
        global $db;

        return $db->query('SELECT * FROM users')->fetchAll();
    }

    public function getUser($id): array {
        global $db;

        return $db->query('SELECT * FROM users WHERE id = ?', $id)->fetchAll();
    }


    public function isAdmin(): bool {
        global $session;

        if ($session->isSignedIn()) {
            if ($session->userRole === 'user') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}