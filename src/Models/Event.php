<?php

namespace Aditya\DetikTest\Models;

use Aditya\DetikTest\Traits\Sanitize;
use PDO;
use PDOException;

class Event
{
    use Sanitize;

    private $conn;
    
    // table name
    private $table = 'events';


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save(Array $input)
    {
        $query = "INSERT INTO " . $this->table . "
                  (name, description) VALUES (:name, :description)"; 

        try {
            
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute(array(
                'name' => $this->preventInjection($input['name']),
                'description' => $this->preventInjection($input['description']) ?? null,
            ));
            return $stmt->rowCount();
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function get($id = null)
    {
        $query = "SELECT * FROM ". $this->table; 
        
        try {
            
            if ($id != null) {
                $query .= " WHERE id = :id";
            }

            $stmt = $this->conn->prepare($query);
            
            if ($id != null) {
                $stmt->bindParam(":id", $id);
                
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        
    }
}
