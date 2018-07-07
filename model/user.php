<?php

class Szerepkor {

    private $szkid, $megnevezes;

    public function __construct($szkid, $megnevezes) {
        $this->szkid = $szkid;
        $this->megnevezes = $megnevezes;
    }

    public function __get($name) {
        return $this->$name;
    }

}

class UserModel extends Model {

    private $fid, $fnev, $szerepkorok, $jelszo_hash, $sikertelen, $utbejeldatum;

    public function __construct() {
        parent::__construct();
        $this->fid = "";
        $this->fnev = "";
        $this->szerepkorok = [];
        $this->jelszo_hash = "";
    }

    public function userFeltolt($fnev) {
        $sql = "SELECT felhasznalok.fid, felhasznalok.fnev, szerepkor.szkid, szerepkor.megnevezes, felhasznalok.jelszo
                FROM
                felhasznalok, szerepkor,felhasznalok_szerepkor
                WHERE
                felhasznalok.fid = felhasznalok_szerepkor.fid
                AND
                felhasznalok_szerepkor.szkid = szerepkor.szkid
                AND felhasznalok.fnev = '" . $this->conn->real_escape_string($fnev) . "'";

        $result = $this->conn->query($sql);

        $h_szerepkor = null;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->fid = $row['fid'];
                $this->fnev = $row['fnev'];
                $h_szerepkor =  new Szerepkor(intval($row['szkid']), $row['megnevezes']);
                array_push($this->szerepkorok,(array) $h_szerepkor);
                $this->jelszo_hash = $row['jelszo'];
            }
        } else {
            $this->fid = "-1";
        }
    }

    public function setSikertelen($fnev, $ip) {
        $sql = "SELECT logid, sikeres
                        FROM
                        log
                        WHERE
                        log.fnev ='" . $this->conn->real_escape_string($fnev) . "'
                        AND
                        log.ip = '" . $this->conn->real_escape_string($ip) . "'
                        AND log.datum = CURRENT_DATE()
                        ORDER BY
                        logid";
        

        $sikertelen = 0;

        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                
                if (!boolval($row['sikeres'])) {
                    $sikertelen++;
                } else {
                    $sikertelen = 0;
                }
            }
            $this->sikertelen = $sikertelen;
        } else {
            $this->sikertelen = 0;
        }
    }

    public function setUtBejelDatum($fnev) {
        $sql = "SELECT datum
                        FROM
                        log
                        WHERE
                        log.fnev ='" . $this->conn->real_escape_string($fnev) . "'
                        AND
                        log.sikeres = 1
                        ORDER BY
                        logid
                        DESC
                        LIMIT 1";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->utbejeldatum = $row['datum'];
            }
        } else {
            $this->utbejeldatum = "Még nem volt bejelentkezve!";
        }
    }

    public function saveLog($fnev,$ip,$sikeres) {
        $sql = "INSERT INTO `log` (`fnev`, `ip`, `datum`, `sikeres`) VALUES ('".$this->conn->real_escape_string($fnev)."','".$this->conn->real_escape_string($ip)."',NOW(),".$this->conn->real_escape_string($sikeres).")";

        $this -> conn->query($sql);
    }

    public function __get($name) {
        return $this->$name;
    }

}
