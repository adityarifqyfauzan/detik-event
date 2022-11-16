<?php

namespace Aditya\DetikTest\Models;

use Aditya\DetikTest\Traits\Sanitize;
use PDO;
use PDOException;

class Ticket
{
    use Sanitize;

    private $conn;
    
    // table name
    private $table = 'tickets';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save(Array $input)
    {
        $query = "INSERT INTO " . $this->table . "
                  (event_id, code) VALUES (:event_id, :code)"; 

        try {
            
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute(array(
                'event_id' => $this->preventInjection($input['event_id']),
                'code' => $this->preventInjection($input['code']),
            ));
            return $stmt->rowCount();
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getByID($id)
    {
        $query = "SELECT * FROM ". $this->table ." WHERE id = :id"; 
        
        try {
            
            $stmt = $this->conn->prepare($query);
    
            // sanitize input from sql injection (remove htmlspecialchars)
            $id = $this->preventInjection($id);
    
            // bind data 
            $stmt->bindParam(":id", $id);
    
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getByCode($code)
    {
        $query = "SELECT * FROM ". $this->table ." WHERE code = :code"; 
        
        try {
            
            $stmt = $this->conn->prepare($query);
    
            // sanitize input from sql injection (remove htmlspecialchars)
            $code = $this->preventInjection($code);
    
            // bind data 
            $stmt->bindParam(":code", $code);
    
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function updateStatus($code, Array $input)
    {
        $query = "UPDATE ". $this->table ." SET status = :status WHERE code = :code"; 

        try {
            
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute(array(
                'code' => $this->preventInjection($code), 
                'status' => $this->preventInjection($input['status']), 
            ));
            return $stmt->rowCount();
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
