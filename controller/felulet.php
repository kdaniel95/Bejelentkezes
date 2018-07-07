<?php

class FeluletController extends Controller {

    private $user_szerepkorok;

    function __construct() {
        parent::__construct();
        $this->user_szerepkorok = $_SESSION['userinfo']['szerepkorok'];
    }

    public function index() {
        if (isset($_SESSION['loggedin'])) {
            $elerhetoMenuk = $this->menulista();

            $szerepkorok_string = $this->szerepkorokstring($this->user_szerepkorok);

            $this->view->data(
                    ['elerhetoMenuk' => $elerhetoMenuk,
                        'fnev' => $_SESSION['userinfo']['fnev'],
                        'utbejeldatum' => $_SESSION['userinfo']['utbejeldatum'],
                        'szerepkorok' => $szerepkorok_string
            ]);

            $this->view->render('felulet/index');
        } else {
            Helper::redirect("./");
        }
    }

    private function menulista() {
        $menuk = "";

        if ($this->benneVanE(1, $this->user_szerepkorok)) {
            $menuk .= "<li><a href='./adminfelulet'>Admin felület</a></li>";
            $menuk .= "<li><a href='./bejelentkezettfelhasznalofelulet'>Bejelentkezett felhasználó felület</a></li>";
            $menuk .= "<li><a href='./tartalomszerkesztofelulet'>Tartalomszerkesztő felület</a></li>";
        }

        if ($this->benneVanE(2, $this->user_szerepkorok)) {
            $menuk .= "<li><a href='./tartalomszerkesztofelulet'>Tartalomszerkesztő felület</a></li>";
        }

        if ($this->benneVanE(3, $this->user_szerepkorok)) {
            $menuk .= "<li><a href='./bejelentkezettfelhasznalofelulet'>Bejelentkezett felhasználó felület</a></li>";
        }

        return $menuk;
    }

    private function benneVanE($keresett, $miben) {

        $index = 0;
        $n = count($miben);

        while ($n > $index && array_values($miben[$index])[0] !== $keresett) {
            $index++;
        }

        return $index < $n;
    }

    private function szerepkorokstring($szerepkorok_arr) {
        $szerepkorok_string = "";

        if (count($szerepkorok_arr) == 1) {
            $szerepkorok_string = array_values($szerepkorok_arr[0])[1];
        } else {
            foreach (array_values($szerepkorok_arr) as $szerepkor) {

                $szerepkorok_string .= array_values($szerepkor)[1] . " + ";
            }
            $szerepkorok_string = substr($szerepkorok_string, 0, strlen($szerepkorok_string) - 3);
        }


        return $szerepkorok_string;
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
            if ($this->benneVanE(1, $this->user_szerepkorok) || $this->benneVanE(3, $this->user_szerepkorok)) {
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
            if ($this->benneVanE(1, $this->user_szerepkorok)) {
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
            if ($this->benneVanE(2, $this->user_szerepkorok) || $this->benneVanE(1, $this->user_szerepkorok)) {
                $this->view->render('felulet/tartalomszerkesztofelulet');
            } else {
                $this->view->render("error/index");
            }
        } else {
            Helper::redirect("./");
        }
    }

}
