<?php
require_once("login.php");
$controller = new login();


$html = $controller->doControll();

$view = new loginView();
$view->echoHTML($html);



	











