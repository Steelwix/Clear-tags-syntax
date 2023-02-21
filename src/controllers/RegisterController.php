<?php
function registerController()
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
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $user = new User(null, $_POST['username'],  $password, null, null, null);
        $userManager = new UserManager();
        $userManager->createUser($user);
        header("Location: /");
        exit();
    }
    require './templates/register.html';
}
