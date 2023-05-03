<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions

// 1. namespace
namespace guestbook;

session_start();

// 2. use

// 3. require_once
//require_once 'vendor/autoload.php';
require_once 'vendor/ autoload.php ';
require_once 'Controllers/HomeController.php';
require_once 'Controllers/RegisterController.php';
require_once 'Controllers/LoginController.php';
require_once 'Controllers/AdminController.php';
require_once 'Controllers/LogoutController.php';
require_once 'Controllers/GuestbookController.php';

// Define the base URL
define('BASE_URL', '/guestbook');

// TODO 2: ROUTING

switch ($_SERVER['REQUEST_URI']) {
    case BASE_URL:
        $controllerClassName = 'GuestbookController';
        break;
    case BASE_URL . '/register':
        $controllerClassName = 'RegisterController';
        break;
    case BASE_URL . '/login':
        $controllerClassName = 'LoginController';
        break;
    case BASE_URL . '/logout':
        $controllerClassName = 'LogoutController';
        break;
    case BASE_URL . '/admin':
        $controllerClassName = 'AdminController';
        break;
    default:
        echo 'Path not found.';
        die;
}

$controllerClassName = "guestbook\Controllers\\$controllerClassName";

$controller = new $controllerClassName();
$controller->execute();
