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

}