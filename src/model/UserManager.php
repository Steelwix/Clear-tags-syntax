<?php
require_once 'DatabaseManager.php';


class UserManager extends DatabaseManager
{
    public function getUsers()
    {
        $req = $this->database->query('SELECT * FROM user');
        return $req;
    }
}
