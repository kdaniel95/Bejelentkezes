<?php

class Session {

    private $db;

    public function __construct() {
        $db = new Database();
        
        $this -> db = $db -> ConnectDatabase();
        
        session_set_save_handler
        (
                [$this, "_open"], 
                [$this, "_close"], 
                [$this, "_read"], 
                [$this, "_write"], 
                [$this, "_destroy"],
                [$this, "_gc"]
        );

        
        session_set_cookie_params(3600,"/");
        session_start();
    }

    public function _open() {
        if ($this->db) {
            return true;
        }

        return false;
    }

    public function _close() {
        if ($this->db->close()) {
            return true;
        }

        return false;
    }

    public function _read($id) {
        $qry_string = "SELECT adat FROM session WHERE sid = '" . $this->db->real_escape_string($id)."'";
        $qry = $this->db->query($qry_string);
        if ($qry) {
            $row = $qry -> fetch_assoc();
            if(is_null($row)){
                return '';
            }
            return $row['adat'];
        }
        
    }

    public function _write($id, $adat) {
        $ido = time();
        $qry_string = "REPLACE INTO session (sid,lejar,adat) VALUES('" . $this->db->real_escape_string($id) . "', '" . $this->db->real_escape_string($ido) . "', '" . $this->db->real_escape_string($adat) . "')";
        $qry = $this->db->query($qry_string);
        if ($qry) {
            return true;
        }
        return false;
    }

    public function _destroy($id) {
        
        $qry_string = "DELETE FROM `session` WHERE sid = '" . $this->db->real_escape_string($id)."'";
        $qry = $this->db->query($qry_string);
        if ($qry) {
            return true;
        }

        return false;
    }

    public function _gc($max) {
        $lejart = time() - $max;

        $qry_string = "DELETE * FROM session WHERE lejar<" . $this->db->real_escape_string($lejart);

        $qry = $this->db->query($qry_string);

        if ($qry) {
            return true;
        }

        return false;
    }

}
