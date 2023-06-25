<?php

use util\HttpErrorCodes;

require_once '../Controller/StockController.php';
require_once '../Connection.php';
require_once '../utils/Response.php';

session_start();

if (!isset($_SESSION['user'])) {
  Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$stockController = StockController::getInstance();
$requestType = $_SERVER['REQUEST_METHOD'];
$u_id = $user['u_id'];

$requestType = $_SERVER['REQUEST_METHOD'];
$portfolioId = $_GET['portfolioId'];

if ($requestType == 'GET') {
  $stockController->getAllByPortfolioId($portfolioId);
}
