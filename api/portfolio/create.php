<?php
use util\HttpErrorCodes;
require_once '../Controller/PortfolioController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];
$u_id = $user['u_id'];

$portfolioController = PortfolioController::getInstance();

if (isset($_POST['currencyId'])) {
    $currencyId = $_POST['currencyId'];
    $portfolioController->createPortfolio($u_id, $currencyId);
} else {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
}