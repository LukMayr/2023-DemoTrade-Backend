<?php
use util\HttpErrorCodes;
require_once '../Controller/PortfolioController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];
$u_id = $user['u_id'];

if ($u_id == null) {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "You are not signed in")->send();
}
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

$portfolioController = PortfolioController::getInstance();

$portfolioController->createPortfolio($u_id);