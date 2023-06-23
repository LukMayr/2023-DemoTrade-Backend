<?php
use util\HttpErrorCodes;
require_once '../Controller/StockController.php';

session_start();

if (!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$stockController = StockController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$stockId = $_GET['stockId'];