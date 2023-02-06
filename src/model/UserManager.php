<?php
require_once 'DatabaseManager.php';

use DatabaseManager;

class UserManager extends DatabaseManager
{
    public function getUsers()
    {
        $req = $this->database->query('SELECT * FROM user');
        return $req;
    }
}
