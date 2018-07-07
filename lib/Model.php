<?php
class Model {
    
    protected $db = NULL;
    protected $conn = NULL;

    function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->ConnectDatabase();
    }

}