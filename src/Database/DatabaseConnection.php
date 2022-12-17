<?php

namespace Shield\Database;

class DatabaseConnection {

    static $instance;

    public $connection;

    public function __construct(){
        $host = env('HOST');
        $driver = env('DRIVER');
        $database = env('DATABASE');
        $user = env('USER');
        $password = env('PASSWORD');

        $this->connection = new \PDO("$driver: host=$host;dbname=$database;", $user, $password);
    }

    static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }
}