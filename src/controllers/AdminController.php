<?php

function homeAdminController()
{

    require './templates/admin/admin.html';
}
function userManageController()
{
    $userManager = new UserManager;
    $users = $userManager->getUsers();
    require './templates/admin/users.html';
}
