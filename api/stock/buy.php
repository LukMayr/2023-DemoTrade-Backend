<?php
use util\HttpErrorCodes;
require_once '../Controller/StockController.php';
require_once '../utils/Response.php';
require_once '../Connection.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}
$_POST = json_decode(file_get_contents('php://input'), true);

$stockController = StockController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$portfolioId = $_POST['portfolioId'];
$name = $_POST['C_NAME'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

echo $portfolioId;
echo $name;
echo $quantity;
echo $price;

if ($requestType != 'POST') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

if ($portfolioId != null && $name != null && $quantity != null && $price != null) {
    $stockController->buyStock($name, $portfolioId, $quantity, $price);
} else {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
}