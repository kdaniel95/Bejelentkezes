<?php
class Database extends mysqli {

    function __construct() {
        ;
    }
    
    public function ConnectDatabase() {
        require 'dbconfig.php';
        $conn = new mysqli(
                $connParam['Host'],
                $connParam['User'],
                $connParam['Pass'],
                $connParam['DbName']
        );
        
        $conn ->set_charset($connParam['CharSet']);
        if($conn->connect_errno){
            die("Adatbázis hiba!!!");
        }
        return $conn;
    }
    
    public function bind_param_assoc($stmt) {
        $meta = $stmt->result_metadata();
        $result = array();
        while($field = $meta->fetch_field()){
            $result[$field->name] = null;
            $params[] = &$result[$field->name];
        }
        
        call_user_func_array(array($stmt, 'bind_result'), $params);
        return $result;
    }

}