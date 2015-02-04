<?php

header('Content-Type: text/html; charset=utf8');

//Подключение дополнений
include_once 'additions/PHPMailer/class.phpmailer.php';
include_once 'additions/phpExcel/PHPExcel.php';
//include_once 'additions/phpExcel/PHPExcel/IOFactory.php';
include_once 'additions/phpExcel/PHPExcel/Writer/Excel5.php';

//Подключение классов
heretic::connect('class/', 'Class.php');
heretic::connect('configuration/', 'Config.php');
heretic::connect(heretic::$_path['models'], '.php');


$database = new databaseClass();
$database ->selectDatabase(heretic::$_config['db']);

session_start();

$router = new routerClass();
$router->delegate();

?>

