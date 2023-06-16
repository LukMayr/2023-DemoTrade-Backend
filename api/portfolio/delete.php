<?php
use util\HttpErrorCodes;
require_once '../Controller/PortfolioController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];

$portfolioController = PortfolioController::getInstance();

if (isset($_GET['portfolioId'])) {
    $portfolioId = $_GET['portfolioId'];
    $portfolioController->deletePortfolio($portfolioId);
} else {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
}