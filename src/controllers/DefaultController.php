<?php



function homeController()
{
    $userManager = new UserManager();
    $posts = $userManager->getUsers();
    require './templates/index.html';
}
function profileController()
{
    $username = "Steelwix";
    require './templates/profile.html';
}
