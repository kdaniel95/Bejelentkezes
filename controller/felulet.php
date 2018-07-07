<?php

class FeluletController extends Controller {
    
    private $user_szerepkorok;
    
    function __construct() {
        parent::__construct();
        $this -> user_szerepkorok = $_SESSION['userinfo']['szerepkorok'];
    }

    public function index() {
        if (isset($_SESSION['loggedin'])) {
            $elerhetoMenuk = $_SESSION['userinfo']['elerhetomenuk'];
            $fnev = $_SESSION['userinfo']['fnev'];
            $utbejeldatum = $_SESSION['userinfo']['utbejeldatum'];
            $szerepkorok = $_SESSION['userinfo']['szerepkorok_string'];
            
            
            

            $this->view->data(
                    ['elerhetoMenuk' => $elerhetoMenuk,
                        'fnev' => $fnev,
                        'utbejeldatum' => $utbejeldatum,
                        'szerepkorok' => $szerepkorok
                    ]);

            $this->view->render('felulet/index');
        } else {
            Helper::redirect("./");
        }
    }

    public function kijelentkezes() {
        if (isset($_SESSION['loggedin'])) {
            session_unset();
            session_destroy();
            session_write_close();
            setcookie(session_name(), '', 0, '/');
            session_regenerate_id(true);
            Helper::redirect("./");
        }
    }

    public function bejelentkezettfelhasznalofelulet() {
        if (isset($_SESSION['loggedin'])) {
            if ($this->benneVan(1, $this->user_szerepkorok) || $this->benneVan(3, $this->user_szerepkorok)) {
                $this->view->render('felulet/bejelentkezettfelhasznalofelulet');
            } else {
                $this->view->render("error/index");
            }
        } else {
            Helper::redirect("./");
        }
    }

    public function adminfelulet() {
        if (isset($_SESSION['loggedin'])) {
            if ($this->benneVan(1, $this->user_szerepkorok)) {
                $this->view->render('felulet/adminfelulet');
            } else {
                $this->view->render("error/index");
            }
        } else {
            Helper::redirect("./");
        }
    }

    public function tartalomszerkesztofelulet() {
        if (isset($_SESSION['loggedin'])) {
            if ($this->benneVan(2, $this->user_szerepkorok) || $this->benneVan(1, $this->user_szerepkorok)) {
                $this->view->render('felulet/tartalomszerkesztofelulet');
            } else {
                $this->view->render("error/index");
            }
        } else {
            Helper::redirect("./");
        }
    }

    private function benneVan($keresett, $miben) {
        $index = 0;
        $n = count($miben);
        while ($n > $index && array_values($miben[$index])[0] !== $keresett) {
            $index++;
        }
        return $index < $n;
    }

}
