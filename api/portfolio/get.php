<?php
use util\HttpErrorCodes;
require_once '../Controller/PortfolioController.php';
require_once '../Controller/UserController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];

$portfolioController = PortfolioController::getInstance();
$userController = UserController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$u_id = $user['u_id'];

if ($requestType == 'GET') {
     $id = $_GET['id'];
    if ($u_id != null) {
        $portfolioController->getPortfoliosById($id);
    } else {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "You are not signed in")->send();
    }
}