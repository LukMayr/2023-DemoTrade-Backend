<?php
use util\HttpErrorCodes;
require_once '../Controller/StockController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$stockController = StockController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$portfolioId = $_GET['portfolioId'];
$stockId = $_GET['stockId'];
$quantity = ($_POST['quantity']);
$price = $_POST['price'];

if ($requestType != 'UPDATE') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

if ($portfolioId != null && $stockId != null && $quantity != null && $price != null) {
    $stockController->buyStock($portfolioId, $stockId, $quantity, $price);
} else {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
}