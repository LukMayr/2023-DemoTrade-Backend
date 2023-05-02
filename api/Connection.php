<?php
class Connection{
    private static $dbConnection = null;
    public static function getConnection()
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $host = $env['HOST'];
        $db   = $env['DBNAME'];
        $user = $env['USER'];
        $pass = $env['PASS'];
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
        echo("trying connection");
            self::$instance = new Connection();
        }
        echo("connected " + self::$instance);
        return self::$instance;
    }


    private function __construct() {
        self::getConnection();
        echo("connected" + self::$instance);
        if(self::$instance != null){
            print("suppa");
        }
    }

}