<?php



function homeController()
{
    require './templates/index.html';
}
function profileController()
{
    $username = "Steelwix";
    require './templates/profile.html';
}
