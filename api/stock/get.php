<?php
use util\HttpErrorCodes;
require_once '../Controller/StockController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$stockController = StockController::getInstance();
$requestType = $_SERVER['REQUEST_METHOD'];
$id = $user['u_id'];

$requestType = $_SERVER['REQUEST_METHOD'];
$portfolioId = $_GET['portfolioId'];
$stockId = $_GET['stockId'];

if ($requestType == 'GET') {
    $id = $_GET['id'];
    if ($u_id != null) {
        $portfolioController->getPortfoliosById($id);
    } else {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "You are not signed in")->send();
    }
}
