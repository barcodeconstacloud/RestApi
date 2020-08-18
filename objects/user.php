<?php

class User{
  
    // database connection and table name
    private $conn;
    private $tableName = "user";
  
    // object properties
    public $id = array();
    public $name;
    public $Email;
    public $Phone;
    public $City;
    public $idStr;
    public $count;
    public $str = array();
    
  
    // constructor with $db as database connection
    public function __construct($db){
        $this -> conn = $db;
    }
    
    public function read(){
        
        foreach($this -> id as $val) {
            $this -> str = explode(',', $val);
            $this -> count = count($this -> str);
            if($this -> count > 0) {
                $this -> id = array();
                for($i = 0; $i < $this -> count; $i++) {
                    $this -> id[] = $this -> str[$i];
                }
            }                       
        }
        $this -> idStr = "'".implode("', '", $this -> id)."'";
        
    
        // select all query
        $query = "SELECT * FROM " . $this->tableName . " u where u.id IN (".$this -> idStr.")";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}

