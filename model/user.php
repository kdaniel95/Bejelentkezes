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
                $h_szerepkor = new Szerepkor(intval($row['szkid']), $row['megnevezes']);
                array_push($this->szerepkorok, $h_szerepkor);
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

    public function mentLog($fnev, $ip, $sikeres) {
        $sql = "INSERT INTO `log` (`fnev`, `ip`, `datum`, `sikeres`) VALUES ('" . $this->conn->real_escape_string($fnev) . "','" . $this->conn->real_escape_string($ip) . "',NOW()," . $this->conn->real_escape_string($sikeres) . ")";

        $this->conn->query($sql);
    }

     private function szerepkorok_string($szerepkorok_arr) {
        $szerepkorok_string = "";
        if (count($szerepkorok_arr) == 1) {
            $szerepkorok_string = $szerepkorok_arr[0] -> megnevezes;
        } else {
            foreach ($szerepkorok_arr as $k => $v) {
                $szerepkorok_string .= $v -> megnevezes." + ";
            }
            $szerepkorok_string = substr($szerepkorok_string, 0, strlen($szerepkorok_string) - 3);
        }

        return $szerepkorok_string;
    }
    
    public function user_infok() {
        return 
        [
            'fnev' => $this->fnev,
            'utbejeldatum' => $this->utbejeldatum,
            'szerepkorok' => $this->tombosit($this -> szerepkorok),
            'szerepkorok_string' => $this-> szerepkorok_string($this-> szerepkorok),
            'elerhetomenuk' => $this->elerheto_menuk()
        ];
    }
    
    public function elerheto_menuk(){
        $menuk = "";

        if ($this->benneVan(1, $this->szerepkorok)) {
            $menuk .= "<li><a href='./adminfelulet'>Admin felület</a></li>";
            $menuk .= "<li><a href='./bejelentkezettfelhasznalofelulet'>Bejelentkezett felhasználó felület</a></li>";
            $menuk .= "<li><a href='./tartalomszerkesztofelulet'>Tartalomszerkesztő felület</a></li>";
        }

        if ($this->benneVan(2, $this->szerepkorok)) {
            $menuk .= "<li><a href='./tartalomszerkesztofelulet'>Tartalomszerkesztő felület</a></li>";
        }

        if ($this->benneVan(3, $this->szerepkorok)) {
            $menuk .= "<li><a href='./bejelentkezettfelhasznalofelulet'>Bejelentkezett felhasználó felület</a></li>";
        }

        return $menuk;
    }
    
    private function benneVan($keresett, $miben){
        $index = 0;
        $n = count($miben);

        while ($n > $index && $miben[$index] -> szkid != $keresett) {
            $index++;
        }

        return $index < $n;
    }
    
    private function tombosit($mit){
        $tmp_tomb = [];
        
        foreach($mit as $k=> $v){
            array_push($tmp_tomb, (array)$v);
        }
        return $tmp_tomb;
    }

    public function __get($name) {
        return $this->$name;
    }

}
