<?php

use util\HttpErrorCodes;

require_once '../utils/Response.php';
require_once '../Controller/UserController.php';

session_start();

//api works with this line when using Web but not with Postman
$_POST = json_decode(file_get_contents('php://input'), true);

$env = parse_ini_file(__DIR__ . '/../../.env');
$salt = $env['SALT'];

$username = $_POST['username'];
$password = $_POST['password'];

echo "email: " . $username . "\n".
        "password:" . $password;;

if ($username == null || $password == null) {
    echo "Missing parameters";
    echo $username;
    echo $password;
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
}

$dbUser = UserController::getInstance()->getUserByUsername($username)[0];

if ($dbUser == null) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "User not found")->send();
}

$passwordHash = hash('sha256', $password. $salt);

if(!password_verify($passwordHash, $dbUser['u_password'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "Wrong password")->send();
}

$_SESSION['user'] = $dbUser;

Response::ok("Login successful", $dbUser)->send();