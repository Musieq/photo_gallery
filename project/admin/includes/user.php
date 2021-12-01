<?php


class User {

    public function getAllUsers(): array {
        global $db;

        return $db->query('SELECT * FROM users')->fetchAll();
    }

}