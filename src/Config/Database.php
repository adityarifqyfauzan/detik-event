<?php 

namespace Aditya\DetikTest\Config;

use PDO;
use PDOException;

class Database
{
    private $connection;
    
    public function connection()
    {
        try {

            $stmt = getenv('DB_CONNECTION') . ':host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME');
            $this->connection = new PDO($stmt, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $this->connection;

        } catch (PDOException $e) {
            exit("unable to connect to database: " . $e->getMessage());
        }
    }

    public function initDB()
    {
        try {
            
            $stmt = getenv('DB_CONNECTION') . ':host=' . getenv('DB_HOST') . ';';
            $this->connection = new PDO($stmt, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

            $db_name = getenv('DB_NAME');
            $sql = "CREATE DATABASE IF NOT EXISTS " . $db_name;
            $this->connection->exec($sql);
            echo "DB " . $db_name . " successful created";
            
            $this->connection = null;

        } catch (PDOException $e) {
            
            exit("can't create database: " . $e->getMessage());

        }
    }

    public function __destruct()
    {
        $this->connection = null;   
    }
}
