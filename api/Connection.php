<?php
class Connection{
    private static ?mysqli $dbConnection = null;

    public static function getConnection()
    {

        $env = parse_ini_file(__DIR__ . '/../env/.env');

        

        $host = $env['HOST'];
        $db   = $env['DBNAME'];
        $user = $env['USER'];
        $pass = $env['PASSWORD'];
        if (self::$dbConnection == null){
            self::$dbConnection = new mysqli($host, $user, $pass, $db);
            if (self::$dbConnection->connect_error) {
                die("Connection failed: " . self::$dbConnection->connect_error);
            }

        }
        return self::$dbConnection;
    }

    private static ?Connection $instance = null;

    public static function getInstance(): Connection
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }


    private function __construct() {
        self::getConnection();
    }
}