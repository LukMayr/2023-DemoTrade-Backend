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
    if ($u_id != null) {
        $portfolioController->getAllPortfoliosByUserId($u_id);
    } else {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
    }
}
else{
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}