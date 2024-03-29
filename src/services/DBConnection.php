<?php
use PgSql\Connection;
class DBConnection {
    private static $instance;
    private Connection|false $connection;

    private function __construct() {
        $this->connection = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=password");
        if (!$this->connection) {
            die("Ошибка подключения к базе данных");
        }
    }

    public static function getInstance(): DBConnection
    {
        if (self::$instance === null) {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getConnection(): false|Connection
    {
        return $this->connection;
    }
}
?>
