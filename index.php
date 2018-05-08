<?php
session_start();

//include config
require('config.php');

require('classes/Messages.php');
require('classes/Bootstrap.php');
require('classes/Controller.php');
require('classes/Model.php');
require('classes/APIGW2.php');

require('controllers/home.php');
require('controllers/users.php');
require('controllers/content.php');

require('models/home.php');
require('models/user.php');
require('models/content.php');

$bootstrap = new Bootstrap($_GET);
$controller = $bootstrap->createController();
if ($controller){
    $controller->executeAction();
}