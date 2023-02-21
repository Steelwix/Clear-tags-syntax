<?php
require_once 'DatabaseManager.php';


class UserManager extends DatabaseManager
{
    public function getUsers()
    {
        $req = $this->database->query('SELECT * FROM user');
        $users = array();
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['id'], $row['username'], $row['password'], $row['roles'], $row['bestScore'], $row['lastScore']);
            $users[] = $user;
        }
        return $users;
    }
    public function createUser(User $user)
    {
        $req = $this->database->prepare("INSERT INTO user(id, username, password, roles, bestScore, lastScore)
        VALUES(NULL, :username, :password, :roles, NULL, NULL)");
        $req->execute(array(':username' => $user->getUsername(), ':password' => $user->getPassword(), ':roles' => "ROLE_USER"));
        return $req;
    }
}
