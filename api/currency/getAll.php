<?php

use util\HttpErrorCodes;

require_once '../Controller/CurrencyController.php';
require_once '../Controller/UserController.php';

session_start();

if (!isset($_SESSION['user'])) {
  Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];

$currencyController = CurrencyController::getInstance();
$userController = UserController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$u_id = $user['u_id'];


if ($requestType == 'GET') {
  $currencies = $currencyController->getAllCurrencies();
  Response::ok("Currencies found", $currencies)->send();

} else {
  Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}
