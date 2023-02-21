<?php


function loginController()
{
    if (!isset($_POST['username']) or !isset($_POST['password'])) {


        $username = $password = "";
        $username_err = $password_err = $login_err = "";
    } else {
        $username = $_POST['username'];
        $password = "";
    }
    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST['username']))) {
            $username_err = "Vous devez entrer votre pseudo.";
        }
        $username = trim($_POST['username']);
        if (empty(trim($_POST['password']))) {
            $password_err = "Vous devez entrer votre mot de passe.";
        }
        $password = trim($_POST['password']);
        $userManager = new UserManager();
        $users = $userManager->getUsers();
        foreach ($users as $user) {
            if ($_POST['username'] == $user->getUsername() && $_POST['password'] == $user->getPassword()) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['id'] = $user->getId();
                $_SESSION['bestScore'] = $user->getBestScore();
                $_SESSION['lastScore'] = $user->getLastScore();
                header("Location: /");
                exit();
            }
            $login_err = "We don't recognize this username or this password";
        }
    }
    require './templates/login.html';
}
function logoutController()
{
    session_destroy();
    foreach ($_SESSION as $session) {
        unset($session);
    }
    header("Location: /");
    exit();
}
