<?php

use util\HttpErrorCodes;

require_once '../Controller/UserController.php';

    session_start();

    if(!isset($_SESSION['user'])) {
        Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
    }

    $user = $_SESSION['user'];

    $controller = UserController::getInstance();

    $requestType = $_SERVER['REQUEST_METHOD'];
    $id = $user['u_id'];

    if ($requestType != 'GET') {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
    }

    if ($id != null) {
        $controller->getUser($id);
    } else {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
    };
